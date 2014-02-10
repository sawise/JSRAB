package com.ex.jsrab;


import android.app.Dialog;
import android.app.ProgressDialog;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.Fragment;
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
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.ListView;
import android.widget.Spinner;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.List;

public class Search extends Fragment implements View.OnClickListener, ListView.OnItemClickListener {
    private ArrayAdapter<Searchresult> adapter;
    private List<Searchresult> data = new ArrayList<Searchresult>();
    private List<Tiresize> dataTiresize = new ArrayList<Tiresize>();
    private List<Tirethread> dataTirethread = new ArrayList<Tirethread>();
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
    private int allowedRetries = 10;
    private Spinner spinner1, spinner2;
    private Button btnSubmit;




    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.searchtest, container, false);
        setHasOptionsMenu(true);

        searchresult = (ListView) rootView.findViewById(R.id.searchresult);
        searchText = (EditText) rootView.findViewById(R.id.searchText);
        searchButton = (ImageButton) rootView.findViewById(R.id.searchButton);

        datatoList = new ArrayList<Searchresult>();

        progress = new ProgressDialog(getActivity());
        progress.setTitle("Loading");
        progress.setMessage("Please wait...");


        searchresult.setOnItemClickListener(this);
        searchButton.setOnClickListener(this);
        return rootView;
    }


    @Override
    public void onCreateOptionsMenu(Menu menu, MenuInflater inflater) {
        inflater.inflate(R.menu.drinkmenu, menu);
        super.onCreateOptionsMenu(menu, inflater);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.advsearch:
                advSearchdialog();
            return true;
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
            progress.show();
           try{
               data.clear();
               data = APIManager.getSearchresults(searchString);
               //adapter = new ArrayAdapter<String>(this.getActivity(), R.layout.custom_list_item, datatoList);
               if(!data.isEmpty()) {
                   adapter = new CustomSearchAdapter(this.getActivity(), R.layout.customsearch, datatoList);
                   if(!adapter.isEmpty()){
                       adapter.clear();
                   }
                   searchresult.setAdapter(adapter);
                   //APIManager.updateSearch();
                   for(Searchresult searchdata : data){
                           Searchresult stringToAdd = new Searchresult(searchdata.getId(),searchdata.getDate() ,searchdata.getCustomerName() ,searchdata.getTirethreadName(), searchdata.getTiresizeName(), searchdata.getComments(), searchdata.getTotal());
                           //String stringToAdd = "Leveransdatum: "+searchdata.getDate()+"\n"+"Kund: "+searchdata.getCustomerName()+"\n"+"Mönster: "+searchdata.getTirethreadName()+"\n"+"Dimension: "+searchdata.getTiresizeName()+"\n"+"Totalt: "+searchdata.getTotal();
                           adapter.add(stringToAdd);
                   }
                   progress.dismiss();
                } else {
                   startRefreshThread();
               }
           } catch (Exception e){
               Log.i("Post", ""+e);
           }
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
                            data = APIManager.getSearchresults(searchString);
                            adapter = new CustomSearchAdapter(getActivity(), R.layout.customsearch, datatoList);
                            if (!data.isEmpty()) {
                                adapter.clear();
                                for(Searchresult searchdata : data){
                                    Searchresult stringToAdd = new Searchresult(searchdata.getId(),searchdata.getDate() ,searchdata.getCustomerName() ,searchdata.getTirethreadName(), searchdata.getTiresizeName(), searchdata.getComments(), searchdata.getTotal());
                                    //String stringToAdd = "Leveransdatum: "+searchdata.getDate()+"\n"+"Kund: "+searchdata.getCustomerName()+"\n"+"Mönster: "+searchdata.getTirethreadName()+"\n"+"Dimension: "+searchdata.getTiresizeName()+"\n"+"Totalt: "+searchdata.getTotal();
                                    adapter.add(stringToAdd);
                                }
                                searchresult.setAdapter(adapter);
                                progress.dismiss();
                            } else {
                                Log.i("retry...", "yes o.O");
                                retries++;
                                if(retries < allowedRetries){
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
            dialog(itemid, data.get(position));
            //selectedItem = position;
            //String text = gridArray.get(position).getName();
            //String category = gridArray.get(position).getCategoryName();
            //int imageId = gridArray.get(position).getImageId();

            //dialog(category,gridArray.get(position).imageResourceId, text);
        }
    }


    public void advSearchdialog(){
        final Dialog dialog = new Dialog(getActivity());
        dialog.setContentView(R.layout.searchadvdialog);
        dialog.setTitle("text");
        dialog.setCancelable(true);
        spinner1 = (Spinner) dialog.findViewById(R.id.spinner1);
        spinner2 = (Spinner) dialog.findViewById(R.id.spinner2);
        btnSubmit = (Button) dialog.findViewById(R.id.setAdvsearch);

        tiresizes = APIManager.getTiresizes();
        tirethreads = APIManager.getTirethreads();



        spinner1.setOnItemSelectedListener(new CustomOnItemSelectedListener());
        List<String> list = new ArrayList<String>();
        list.add("list 1");
        list.add("list 2");
        list.add("list 3");
        ArrayAdapter<String> dataAdapter = new ArrayAdapter<String>(getActivity(),
                android.R.layout.simple_spinner_item, list);
        dataAdapter.setDropDownViewResource(android.R.layout.simple_spinner_dropdown_item);
        spinner2.setAdapter(dataAdapter);

        btnSubmit.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {

                Toast.makeText(getActivity(),
                        "OnClickListener : " +
                                "\nSpinner 1 : " + String.valueOf(spinner1.getSelectedItem()) +
                                "\nSpinner 2 : " + String.valueOf(spinner2.getSelectedItem()),
                        Toast.LENGTH_SHORT).show();
            }

        });

        dialog.show();

    }





    public void dialog(int id, Searchresult searchitem){

        final Dialog dialog = new Dialog(getActivity());
        dialog.setContentView(R.layout.searchresultdialog);
        dialog.setTitle("text");
        dialog.setCancelable(true);

        TextView dialogText = (TextView) dialog.findViewById(R.id.dialogText);
        Button removeButton = (Button) dialog.findViewById(R.id.buttonRemove);
        Button cancelButton = (Button) dialog.findViewById(R.id.buttonCancel);

        removeButton.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {

                /*APIManager.removeIngredientfromAccount(gridArray.get(selectedItem).getId());
                Toast.makeText(getActivity(), "Sucessfully removed: " + gridArray.get(selectedItem).getName(), Toast.LENGTH_SHORT).show();
                gridArray.remove(selectedItem);
                adapter.notifyDataSetChanged();
                dialog.dismiss();
                startRefreshThread();*/
            }
        });
        cancelButton.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                dialog.dismiss();
            }
        });
        String dialogTextStr = "Leveransdatum: "+searchitem.getDate()+"\n"+"Kund: "+searchitem.getCustomerName()+"\n"+"Mönster: "+searchitem.getTirethreadName()+"\n"+"Dimension: "+searchitem.getTiresizeName()+"\n"+"Totalt: "+searchitem.getTotal()+"\nKommentarer: "+searchitem.getComments();
        dialogText.setText(dialogTextStr);

        dialog.show();

    }

    public void getTiresize(){
        try{
            dataTiresize.clear();
            dataTiresize = APIManager.getTiresizes();
            //adapter = new ArrayAdapter<String>(this.getActivity(), R.layout.custom_list_item, datatoList);
            if(!data.isEmpty()) {
                adapter = new CustomSearchAdapter(this.getActivity(), R.layout.customsearch, datatoList);
                if(!adapter.isEmpty()){
                    adapter.clear();
                }
                searchresult.setAdapter(adapter);
                //APIManager.updateSearch();
                for(Searchresult searchdata : data){
                    Searchresult stringToAdd = new Searchresult(searchdata.getId(),searchdata.getDate() ,searchdata.getCustomerName() ,searchdata.getTirethreadName(), searchdata.getTiresizeName(), searchdata.getComments(), searchdata.getTotal());
                    //String stringToAdd = "Leveransdatum: "+searchdata.getDate()+"\n"+"Kund: "+searchdata.getCustomerName()+"\n"+"Mönster: "+searchdata.getTirethreadName()+"\n"+"Dimension: "+searchdata.getTiresizeName()+"\n"+"Totalt: "+searchdata.getTotal();
                    adapter.add(stringToAdd);
                }
                progress.dismiss();
            } else {
                startRefreshThread();
            }
        } catch (Exception e){
            Log.i("Post", ""+e);
        }
    }
}
