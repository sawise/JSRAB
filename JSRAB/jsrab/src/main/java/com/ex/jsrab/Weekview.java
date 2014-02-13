package com.ex.jsrab;


import android.app.Dialog;
import android.app.ProgressDialog;
import android.app.TabActivity;
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
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.TextView;
import android.widget.Toast;

import java.text.DateFormatSymbols;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

public class Weekview extends Fragment implements ListView.OnItemClickListener {


    private ArrayAdapter<Searchresult> adapter;
    private List<Searchresult> data = new ArrayList<Searchresult>();
    private ArrayList<Searchresult> datatoList;
    private ListView weeklistview;
    private EditText week;
    private Button setDate, cancelDialog;
    private DatePicker datePicker;
    private ProgressDialog progress;
    int yearInt = 2014;
    int weekInt = 1;
    int monthInt = 0;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.weekview, container, false);
        setHasOptionsMenu(true);

        week = (EditText) rootView.findViewById(R.id.week);
        weeklistview = (ListView) rootView.findViewById(R.id.weeklistview);
        datatoList = new ArrayList<Searchresult>();

        progress = new ProgressDialog(getActivity());
        progress.setTitle("Laddar...");
        progress.setMessage("Hämtar veckoöversikten...");

        if(Session.getYear() == 0){
            setYearandWeek();
        } else {
            yearInt = Session.getYear();
            weekInt = Session.getWeek();
            monthInt = Session.getMonth();
            week.setText(yearInt+" "+HelperFunctions.getMonthForInt(monthInt)+" v"+weekInt);
            fillListview();
        }

        weeklistview.setOnItemClickListener(this);

        return rootView;
    }



    @Override
    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
        if(parent == weeklistview){
            int itemid = data.get(position).getId();
            dialog(itemid, data.get(position));


            //selectedItem = position;
            //String text = gridArray.get(position).getName();
            //String category = gridArray.get(position).getCategoryName();
            //int imageId = gridArray.get(position).getImageId();

            //dialog(category,gridArray.get(position).imageResourceId, text);
        }
    }

    public void dateDialog(){
        final Dialog dialog = new Dialog(getActivity());
        dialog.setContentView(R.layout.searchyeardialog);
        dialog.setTitle("Välj vecka");
        cancelDialog = (Button) dialog.findViewById(R.id.closeDialog);
        datePicker = (DatePicker) dialog.findViewById(R.id.datePicker);
        Calendar currentDate  = Calendar.getInstance();
        datePicker.init(currentDate.get(Calendar.YEAR), currentDate.get(Calendar.MONTH), currentDate.get(Calendar.DAY_OF_MONTH), new DatePicker.OnDateChangedListener()
        {

            @Override
            public void onDateChanged(DatePicker periodDatePicker, int currentYear, int currentMonth,int currentDay) {
                // TODO Auto-generated method stub
                Calendar choosenDate  = Calendar.getInstance();
                yearInt = currentYear;
                monthInt = currentMonth;
                int d = currentDay;
                choosenDate.set(yearInt, monthInt, d);
                weekInt = choosenDate.get(Calendar.WEEK_OF_YEAR);
                week.setText(yearInt+" "+HelperFunctions.getMonthForInt(monthInt)+" v"+weekInt);
                dialog.dismiss();
                fillListview();

            }
        });


        cancelDialog.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
               dialog.dismiss();
            }
        });
        dialog.setCancelable(true);
        dialog.show();
    }

    @Override
    public void onResume(){
        super.onResume();
        if(Session.getYear() == 0){
            setYearandWeek();
        } else {
            yearInt = Session.getYear();
            weekInt = Session.getWeek();
            monthInt = Session.getMonth();
            week.setText(yearInt+" "+HelperFunctions.getMonthForInt(monthInt)+" v"+weekInt);
            fillListview();
        }
        Log.i("current year and week", yearInt+"<->"+weekInt);


    }
    public void setYearandWeek(){
        Calendar c = Calendar.getInstance();
        yearInt = c.get(Calendar.YEAR);
        Session.setYear(yearInt);
        weekInt = c.get(Calendar.WEEK_OF_YEAR);
        Session.setWeek(weekInt);
        monthInt = c.get(Calendar.MONTH);
        Session.setMonth(monthInt);
        week.setText(yearInt+" "+HelperFunctions.getMonthForInt(monthInt)+" v"+weekInt);
        Log.i("current year and week", yearInt+"<->"+weekInt);
        fillListview();
    }


    public void dialog(int id, Searchresult searchitem){
        final Dialog dialog = new Dialog(getActivity());
        final int idOnclick = id;
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
        String dialogTextStr = "Leveransdag: "+searchitem.getDeliverydate()+"\n"+"Kund: "+searchitem.getCustomerName()+"\n"+"Mönster: "+searchitem.getTirethreadName()+"\n"+"Dimension: "+searchitem.getTiresizeName()+"\n"+"Totalt: "+searchitem.getTotal()+"\nKommentarer: "+searchitem.getComments()+"\nSenast ändrad: "+searchitem.getDeliverydate()+" av "+searchitem.getUsername();
        dialogText.setText(dialogTextStr);

        dialog.show();

    }

    @Override
    public void onCreateOptionsMenu(Menu menu, MenuInflater inflater) {
        inflater.inflate(R.menu.weekviewmenu, menu);
        super.onCreateOptionsMenu(menu, inflater);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.calendar:
                dateDialog();
                return true;
            case R.id.refreshweek:
                fillListview();
            default:
                break;
        }
        return false;
    }




    public void fillListview(){
        Log.i("onclick","yeees");
        progress.show();
        try{
            data.clear();
            data = APIManager.getWeeklyOrders(yearInt, weekInt);
            //adapter = new ArrayAdapter<String>(this.getActivity(), R.layout.custom_list_item, datatoList);
            if(!data.isEmpty()) {
                data = APIManager.getWeeklyOrders(yearInt, weekInt);
                adapter = new CustomSearchAdapter(getActivity(), R.layout.customsearch, datatoList);
                    adapter.clear();

                for(Searchresult searchdata : data){
                    Searchresult stringToAdd = new Searchresult(searchdata.getId(),searchdata.getDeliverydate() ,searchdata.getCustomerName() ,searchdata.getTirethreadName(), searchdata.getTiresizeName(),searchdata.getComments(), searchdata.getTotal(), searchdata.getUsername());

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
                            data = APIManager.getWeeklyOrders(yearInt, weekInt);
                            if (!data.isEmpty()) {
                                adapter = new CustomSearchAdapter(getActivity(), R.layout.customsearch, datatoList);
                                    adapter.clear();
                                for(Searchresult searchdata : data){
                                    Searchresult stringToAdd = new Searchresult(searchdata.getId(),searchdata.getDeliverydate() ,searchdata.getCustomerName() ,searchdata.getTirethreadName(), searchdata.getTiresizeName(),searchdata.getComments(), searchdata.getTotal(), searchdata.getUsername());

                                    adapter.add(stringToAdd);
                                }
                                weeklistview.setAdapter(adapter);
                                progress.dismiss();
                            } else {

                                Log.i("retry...", ""+retries);
                                retries++;
                                if(retries < HelperFunctions.allowedRetries){

                                    try {
                                        if(!adapter.isEmpty() && adapter != null){
                                            adapter.clear();
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
}
