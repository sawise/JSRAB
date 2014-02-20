package com.ex.jsrab;


import android.app.Dialog;
import android.app.ProgressDialog;
import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.Fragment;
import android.text.TextUtils;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

public class Search extends Fragment implements View.OnClickListener, ListView.OnItemClickListener {
    private ArrayAdapter<Searchresult> adapter;
    private List<Searchresult> data = new ArrayList<Searchresult>();
    //private ArrayList<Tiresize> dataTiresize = new ArrayList<Tiresize>();
    //private ArrayList<Tirethread> dataTirethread = new ArrayList<Tirethread>();
    private ArrayList<Searchresult> datatoList;
    private ListView searchresult;
    private EditText searchText;
    private ImageButton searchButton;
    private String searchString = "";
    private String tireThread = "nothread";
    private String tireSize = "nosize";
    private String dateStart = "nodate";
    private String dateEnd = "";
    private ArrayList<Tiresize> tiresizes;
    private ArrayList<Tirethread> tirethreads;
    private ProgressDialog progress;
    private Spinner spinner1, spinner2;
    private int spinner1Pos = 0;
    private int spinner2Pos = 0;
    private CheckBox dimensionCheckbox, threadCheckbox, deliverydateCheckbox;
    private DatePicker datepickerStart, datepickerEnd;
    private Button btnSubmit, btnCancel;
    private MenuItem resetAdv;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.searchtest, container, false);
        setHasOptionsMenu(true);

        searchresult = (ListView) rootView.findViewById(R.id.searchresult);
        searchText = (EditText) rootView.findViewById(R.id.searchText);
        searchButton = (ImageButton) rootView.findViewById(R.id.searchButton);

        datatoList = new ArrayList<Searchresult>();

        progress = new ProgressDialog(getActivity());
        progress.setMessage("Hämtar sökresultat...");

        searchresult.setOnItemClickListener(this);
        searchButton.setOnClickListener(this);
        return rootView;
    }


    @Override
    public void onCreateOptionsMenu(Menu menu, MenuInflater inflater) {
        inflater.inflate(R.menu.searchmenu, menu);
        super.onCreateOptionsMenu(menu, inflater);
        resetAdv = menu.findItem(R.id.resetadvsearch);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.advsearch:
                advSearchdialog();
            return true;
            case R.id.resetadvsearch:
                resetAdv.setVisible(false);
                tireThread = "nothread";
                tireSize = "nosize";
                dateStart = "nodate";
                dateEnd = "";
                spinner1Pos = 0;
                spinner2Pos = 0;
                Toast.makeText(getActivity(), "Den avancerade sökningen är nollställd", Toast.LENGTH_LONG).show();
            default:
                break;
        }
        return false;
    }


    @Override
    public void onClick(View v) {
        if(v == searchButton){
            Log.i("onclick","yeees");
            searchString = searchText.getText().toString();

            HelperFunctions.vibrate(getActivity());
            if(!TextUtils.isEmpty(searchString)){
                getSearchresult();
            } else {
                Toast.makeText(getActivity(), "Du måste skriva in något i sökrutan!", Toast.LENGTH_LONG).show();
            }

        }
    }

    public void getSearchresult(){
        searchString = searchText.getText().toString();
        progress.show();
        try{
            data.clear();
            datatoList.clear();
            data = APIManager.getSearchresults(searchString, tireThread, tireSize, dateStart, dateEnd);
            if(!data.isEmpty()) {
                adapter = new CustomSearchAdapter(this.getActivity(), R.layout.customsearch, datatoList);
                adapter.addAll(data);
                adapter.notifyDataSetChanged();
                /*for(Searchresult searchdata : data){
                    Searchresult stringToAdd = new Searchresult(searchdata.getId(),searchdata.getDeliverydate() ,searchdata.getCustomerName() ,searchdata.getTirethreadName(), searchdata.getTiresizeName(), searchdata.getComments(), searchdata.getTotal(), searchdata.getUsername(), searchdata.getLastChange());

                    adapter.add(stringToAdd);
                }*/
                searchresult.setAdapter(adapter);
                progress.dismiss();
            } else {
                startRefreshThread();
            }
        } catch (Exception e){
            Log.i("Post", ""+e);
        }
    }
    private void startRefreshThread(){
        final Handler handler = new Handler();

        Runnable runnable = new Runnable() {
            int retries = 0;
            boolean stopRetrying = false;

            public void run() {
                do {
                    try {
                        Thread.sleep(500);
                    }
                    catch (InterruptedException e) {
                        e.printStackTrace();
                    }
                    handler.post(new Runnable() {
                        public void run() {

                            Log.i("retry...", "no =)");
                            datatoList.clear();
                            data = APIManager.getSearchresults(searchString, tireThread, tireSize, dateStart, dateEnd);
                            if (!data.isEmpty()) {
                                adapter = new CustomSearchAdapter(getActivity(), R.layout.customsearch, datatoList);
                                adapter.addAll(data);
                                adapter.notifyDataSetChanged();
                                /*for(Searchresult searchdata : data){
                                    Searchresult stringToAdd = new Searchresult(searchdata.getId(),searchdata.getDeliverydate() ,searchdata.getCustomerName() ,searchdata.getTirethreadName(), searchdata.getTiresizeName(), searchdata.getComments(), searchdata.getTotal(), searchdata.getUsername(), searchdata.getLastChange());
                                    adapter.add(stringToAdd);
                                }*/
                                searchresult.setAdapter(adapter);
                                progress.dismiss();
                            } else {
                                Log.i("retry...", "yes o.O");
                                retries++;
                                if(retries < HelperFunctions.allowedRetries){
                                    try {
                                        if(adapter != null){
                                            if(datatoList.isEmpty()){
                                                Toast.makeText(getActivity(),"Det finns inga ordrar med dessa sökkriterierna", Toast.LENGTH_SHORT).show();
                                                adapter.notifyDataSetChanged();
                                            }
                                        }

                                    } catch (Exception e){
                                        e.printStackTrace();
                                    }
                                    stopRetrying = true;
                                    progress.dismiss();
                                }
                            }
                        }
                    });
                } while (data.isEmpty() && !stopRetrying);
            }
        };
        new Thread(runnable).start();
    }

    @Override
    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
        if(parent == searchresult){
            int itemid = data.get(position).getId();
            dialog(itemid,position, data.get(position));
        }
    }


    public void advSearchdialog(){
        final Dialog dialog = new Dialog(getActivity());
        dialog.setContentView(R.layout.searchadvdialog);
        dialog.setTitle("Avancerad sökning");
        dialog.setCancelable(true);
        spinner1 = (Spinner) dialog.findViewById(R.id.spinner1);
        spinner2 = (Spinner) dialog.findViewById(R.id.spinner2);
        dimensionCheckbox = (CheckBox) dialog.findViewById(R.id.dimensionCheckbox);
        threadCheckbox = (CheckBox) dialog.findViewById(R.id.threadCheckbox);
        deliverydateCheckbox = (CheckBox) dialog.findViewById(R.id.deliverydateCheckbox);
        btnSubmit = (Button) dialog.findViewById(R.id.setAdvsearch);
        btnCancel = (Button) dialog.findViewById(R.id.closeAdvsearch);
        datepickerStart = (DatePicker) dialog.findViewById(R.id.dateStart);
        datepickerEnd = (DatePicker) dialog.findViewById(R.id.dateEnd);


        tirethreads = APIManager.getTirethreads();
        tiresizes = APIManager.getTiresizes();

        if(spinner1Pos != 0){
            spinner1.setSelection(spinner1Pos);
            threadCheckbox.setChecked(true);
        }
        if(spinner2Pos != 0){
            spinner2.setSelection(spinner2Pos);
            dimensionCheckbox.setChecked(true);
        }

        TiresizeAdvsearchAdapter tiresizeAdvsearchAdapter = new TiresizeAdvsearchAdapter(getActivity(), tiresizes);
        spinner2.setAdapter(tiresizeAdvsearchAdapter);
        TirethreadAdvsearchAdapter tirethreadAdvsearchAdapter = new TirethreadAdvsearchAdapter(getActivity(), tirethreads);
        spinner1.setAdapter(tirethreadAdvsearchAdapter);

        //getTiresizes();

        btnSubmit.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {

                if(threadCheckbox.isChecked()){
                    spinner1Pos = spinner1.getSelectedItemPosition();
                    Log.i("advanced search", "dimension yees"+spinner1Pos);
                    int threadID = tirethreads.get(spinner1.getSelectedItemPosition()).getId();
                    tireThread = Integer.toString(threadID);
                }
                if(dimensionCheckbox.isChecked()){
                    spinner2Pos = spinner2.getSelectedItemPosition();
                    Log.i("advanced search", "dimension yees"+spinner2Pos);
                    int threadID = tiresizes.get(spinner2.getSelectedItemPosition()).getId();
                    tireThread = Integer.toString(threadID);
                    tireSize = "nosize";
                }
                if(deliverydateCheckbox.isChecked()){
                    int stY = datepickerStart.getYear();
                    int stM = datepickerStart.getMonth();
                    int stD = datepickerStart.getDayOfMonth();
                    int enY = datepickerEnd.getYear();
                    int enM = datepickerEnd.getMonth();
                    int enD = datepickerEnd.getDayOfMonth();
                    dateStart = HelperFunctions.dateToString(stY, stM+1, stD);
                    dateEnd = HelperFunctions.dateToString(enY, enM+1, enD);
                }
                resetAdv.setVisible(true);
                dialog.dismiss();
            }
        });

        btnCancel.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                dialog.dismiss();
            }
        });

        dialog.show();
    }





    public void dialog(int id,int position, Searchresult searchitem){
        final Dialog dialog = new Dialog(getActivity());
        final int idOnclick = id;
        final int positioninListview = position;
        dialog.setContentView(R.layout.searchresultdialog);
        dialog.setTitle("text");
        dialog.setCancelable(true);

        TextView dialogText = (TextView) dialog.findViewById(R.id.dialogText);
        Button removeButton = (Button) dialog.findViewById(R.id.buttonRemove);
        Button cancelButton = (Button) dialog.findViewById(R.id.buttonCancel);
        Button editButton = (Button) dialog.findViewById(R.id.buttonEdit);

        editButton.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                Session.setOrderID(idOnclick);
                getActivity().getActionBar().setSelectedNavigationItem(3);
                dialog.dismiss();
            }
        });
        removeButton.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                ArrayList<String> arrayList = new ArrayList<String>();
                arrayList.add(Integer.toString(idOnclick));
                APIManager.deleteOrder(getActivity(), arrayList);
                datatoList.remove(positioninListview);
                adapter.notifyDataSetChanged();
                dialog.dismiss();
            }
        });

        cancelButton.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                dialog.dismiss();
            }
        });
        String dialogTextStr = "Leveransdag: "+searchitem.getDeliverydate()+"\n"+"Kund: "+searchitem.getCustomerName()+"\n"+"Mönster: "+searchitem.getTirethreadName()+"\n"+"Dimension: "+searchitem.getTiresizeName()+"\n"+"Totalt: "+searchitem.getTotal()+"\nKommentarer: "+searchitem.getComments()+"\nSenast ändrad: "+searchitem.getLastChange()+" av "+searchitem.getUsername();
        dialogText.setText(dialogTextStr);

        dialog.show();

    }

    /*public void getTirethreads(){
        Log.i("onclick", "yeees");
        try{
            tirethreads = APIManager.getTirethreads();
            threadToList.clear();
            if (!tirethreads.isEmpty()) {
                threadAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, threadToList);
                threadAdapter.notifyDataSetChanged();
                for(Tirethread tirethread : tirethreads){
                    threadAdapter.add(tirethread.getName());
                }
                thread.setAdapter(threadAdapter);
                closeProgress();
            } else {
                startRefreshtireThread();
            }
        } catch (Exception e){
            Log.i("Post", ""+e);
        }
    }*/

    /*public void closeProgress(){
        Log.i("dbcount",DBtablecountInt+"");
        if(DBtablecountInt+1 < totalDBtable){
            Log.i("dbcount+1",DBtablecountInt+"");
            DBtablecountInt = DBtablecountInt+1;
        } else if(DBtablecountInt+1 == totalDBtable){
            DBtablecountInt = DBtablecountInt+1;
            progressAdv.dismiss();
            Log.i("dbcount == 3",DBtablecountInt+"");
            DBtablecountInt = 0;
        }
    }

    public void getTiresizes(){
        Log.i("onclick","yeees");

        try{
            tiresizes = APIManager.getTiresizes();
            dataTiresize.clear();
            if (!tiresizes.isEmpty()) {
                TiresizeAdvsearchAdapter tiresizeAdvsearchAdapter = new TiresizeAdvsearchAdapter(getActivity(), dataTiresize);

                for(Tiresize tiresize : tiresizes){
                    Tiresize tiresizetoSpinner = new Tiresize(tiresize.getId(), tiresize.getName());
                    dataTiresize.add(tiresizetoSpinner);
                }
                spinner2.setAdapter(tiresizeAdvsearchAdapter);
                closeProgress();
            } else {
                startRefreshtireSize();
            }
        } catch (Exception e){
            Log.i("Post", ""+e);
        }
    }

    private void startRefreshtireSize(){
        final Handler handler = new Handler();
        Runnable runnable = new Runnable() {
            int retries = 0;
            boolean stopRetrying = false;
            public void run() {
                do {
                    try {
                        Thread.sleep(500);
                    }
                    catch (InterruptedException e) {
                        e.printStackTrace();
                    }
                    handler.post(new Runnable() {
                        public void run() {
                            tiresizes = APIManager.getTiresizes();
                            dataTiresize.clear();
                            if(!tiresizes.isEmpty()){
                                tiresizeAdvsearchAdapter = new TiresizeAdvsearchAdapter(getActivity(), dataTiresize);
                                for(Tiresize tiresize : tiresizes){
                                    Tiresize tiresizetoSpinner = new Tiresize(tiresize.getId(), tiresize.getName());
                                    dataTiresize.add(tiresizetoSpinner);
                                }
                                spinner2.setAdapter(tiresizeAdvsearchAdapter);
                                closeProgress();
                            } else {
                                retries++;
                                if(retries < HelperFunctions.allowedRetries){
                                    stopRetrying = true;
                                }
                            }
                        }
                    });
                } while (tiresizes.isEmpty() && !stopRetrying);
            }
        };
        new Thread(runnable).start();
    }
*/
    /*private void startRefreshtireThread(){
        final Handler handler = new Handler();
        Runnable runnable = new Runnable() {
            int retries = 0;
            boolean stopRetrying = false;

            public void run() {
                do {
                    try {
                        Thread.sleep(500);
                    }
                    catch (InterruptedException e) {
                        e.printStackTrace();
                    }
                    handler.post(new Runnable() {
                        public void run() {
                            tirethreads = APIManager.getTirethreads();
                            threadToList.clear();
                            if (!tirethreads.isEmpty()) {
                                threadAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, threadToList);
                                threadAdapter.notifyDataSetChanged();
                                for(Tirethread tirethread : tirethreads){
                                    threadAdapter.add(tirethread.getName());
                                }
                                thread.setAdapter(threadAdapter);
                                closeProgress();
                            } else {
                                retries++;
                                if(retries < HelperFunctions.allowedRetries){
                                    try {
                                        if(threadAdapter != null){
                                            if(threadToList.isEmpty()){
                                                threadAdapter.notifyDataSetChanged();
                                            }
                                        }
                                    } catch (Exception e){
                                        e.printStackTrace();
                                    }
                                    stopRetrying = true;
                                }
                            }
                        }
                    });
                } while (tirethreads.isEmpty() && !stopRetrying);
            }
        };
        new Thread(runnable).start();
    }*/
}
