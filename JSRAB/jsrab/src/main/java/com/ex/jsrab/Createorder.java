package com.ex.jsrab;


import android.app.Dialog;
import android.app.ProgressDialog;
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
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.TextView;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

public class Createorder extends Fragment implements EditText.OnClickListener {

    private EditText deliverydate, comments, total;
    public static TextView toast;
    private AutoCompleteTextView thread, dimension, customer;
    private Button setDate, cancelDialog;
    private ImageButton createOrder;
    private DatePicker datePicker;

    private ArrayList<String> customerToList = new ArrayList<String>();
    private ArrayList<String> dimensionToList = new ArrayList<String>();
    private ArrayList<String> threadToList = new ArrayList<String>();


    private ArrayAdapter<String> customerAdapter, threadAdapter, dimensionAdapter;

    private ArrayList<Customer> customers;
    private ArrayList<Tiresize> tiresizes;
    private ArrayList<Tirethread> tirethreads;
    private ProgressDialog progress;
    private int totalDBtable = 2;
    private int DBtablecountInt = 0;
    private Calendar currentDate;
    private int yPost, mPost, dPost;




    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.createorder, container, false);
        setHasOptionsMenu(true);

        toast = (TextView) rootView.findViewById(R.id.toast);
        toast.setText("fungerar..... not!");
        customer = (AutoCompleteTextView) rootView.findViewById(R.id.customer);
        dimension = (AutoCompleteTextView) rootView.findViewById(R.id.dimension);
        thread = (AutoCompleteTextView) rootView.findViewById(R.id.thread);
        deliverydate = (EditText) rootView.findViewById(R.id.deliverydate);
        comments = (EditText) rootView.findViewById(R.id.comments);
        total = (EditText) rootView.findViewById(R.id.total);
        createOrder = (ImageButton) rootView.findViewById(R.id.postOrder);

        currentDate  = Calendar.getInstance();
        yPost = currentDate.get(Calendar.YEAR);
        mPost = currentDate.get(Calendar.MONTH)+1;
        dPost = currentDate.get(Calendar.DAY_OF_MONTH);
        Log.i("calendarr", yPost+"-"+mPost+""+dPost);


        createOrder.setOnClickListener(this);
        deliverydate.setOnClickListener(this);

        return rootView;
    }

    @Override
    public void onResume(){
        super.onResume();
        progress = new ProgressDialog(getActivity());
        progress.setMessage("Hämtar dimensioner, mönster och kunder...");
        //progress.show();
        getCustomers();

    }

    @Override
    public void onCreateOptionsMenu(Menu menu, MenuInflater inflater) {
        inflater.inflate(R.menu.createorder, menu);
        super.onCreateOptionsMenu(menu, inflater);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.refreshcreate:
                getCustomers();
                return true;
            default:
                break;
        }
        return false;
    }

    @Override
    public void onClick(View v) {
        if(v == deliverydate){
            dialog();
            Toast.makeText(getActivity(), "Favorized ", 1000).show();
        } else if(v == createOrder){
            Log.i("Post ID", "");
            ArrayList<String> arrayList = new ArrayList<String>();
            arrayList.add(deliverydate.getText().toString());
            arrayList.add(customer.getText().toString());
            arrayList.add(dimension.getText().toString());
            arrayList.add(thread.getText().toString());
            arrayList.add(total.getText().toString());
            arrayList.add(comments.getText().toString());
            arrayList.add(Session.getUserIdStr());
            //arrayList.add(HelperFunctions.dateToString(yPost, mPost, dPost));
            APIManager.createOrder(getActivity(), arrayList);
        }
    }

    public void dialog(){
        final Dialog dialog = new Dialog(getActivity());
        dialog.setContentView(R.layout.createorderdialog);
        dialog.setTitle("Välj datum");
        dialog.setCancelable(true);
        cancelDialog = (Button) dialog.findViewById(R.id.closeDialogCreateOrder);
        datePicker = (DatePicker) dialog.findViewById(R.id.datePickerCreateOrder);
        Calendar currentDate  = Calendar.getInstance();
        datePicker.init(currentDate.get(Calendar.YEAR), currentDate.get(Calendar.MONTH), currentDate.get(Calendar.DAY_OF_MONTH), new DatePicker.OnDateChangedListener()
        {

            @Override
            public void onDateChanged(DatePicker periodDatePicker, int currentYear, int currentMonth,int currentDay) {
                Log.i("datepickerr", HelperFunctions.dateToString(currentYear, currentMonth + 1, currentDay));
                deliverydate.setText(HelperFunctions.dateToString(currentYear, currentMonth + 1, currentDay));
                dialog.dismiss();

            }
        });

        cancelDialog.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                dialog.dismiss();
                return;
            }
        });
        dialog.show();
    }

    public void getCustomers(){
        Log.i("onclick", "yeees");

        try{
            customers = APIManager.getCustomers();
            customerToList.clear();
            customer.setHint("Hämtar kunder....");

            if (!customers.isEmpty()) {
                customerAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, customerToList);
                customerAdapter.notifyDataSetChanged();
                for(Customer customer : customers){
                    customerAdapter.add(customer.getName());
                }
                customer.setAdapter(customerAdapter);
                //closeProgress();
                customer.setHint("Kund");
                getTiresizes();
            } else {
                startRefreshCustomer();
            }
        } catch (Exception e){
            Log.i("Post", ""+e);
        }
    }

    private void startRefreshCustomer(){
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
                            customers = APIManager.getCustomers();
                            customerToList.clear();
                            customer.setHint("Hämtar kunder....");
                            if (!customers.isEmpty()) {
                                customerAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, customerToList);
                                customerAdapter.notifyDataSetChanged();
                                for(Customer customer : customers){
                                    customerAdapter.add(customer.getName());
                                }

                                customer.setHint("Kund");
                                customer.setAdapter(customerAdapter);
                                //closeProgress();
                                getTiresizes();
                            } else {
                                retries++;
                                if(retries < HelperFunctions.allowedRetries){
                                    stopRetrying = true;
                                }
                            }
                        }
                    });
                } while (customers.isEmpty() && !stopRetrying);
            }
        };
        new Thread(runnable).start();
    }

    public void getTiresizes(){
        Log.i("onclick","yeees");

        try{
            tiresizes = APIManager.getTiresizes();
            dimension.setHint("Hämtar dimensioner...");
            dimensionToList.clear();
            if (!tiresizes.isEmpty()) {
                dimensionAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, dimensionToList);
                dimensionAdapter.notifyDataSetChanged();
                for(Tiresize tiresize : tiresizes){
                    dimensionAdapter.add(tiresize.getName());
                }
                dimension.setHint("Dimensioner");
                dimension.setAdapter(dimensionAdapter);
                getTirethreads();
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
                            dimension.setHint("Hämtar dimensioner...");
                            dimensionToList.clear();
                            if (!tiresizes.isEmpty()) {
                                dimensionAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, dimensionToList);
                                dimensionAdapter.notifyDataSetChanged();
                                for(Tiresize tiresize : tiresizes){
                                    dimensionAdapter.add(tiresize.getName());
                                }
                                dimension.setHint("Dimensioner");
                                dimension.setAdapter(dimensionAdapter);
                                getTirethreads();
                            } else {
                                retries++;
                                if(retries < HelperFunctions.allowedRetries){
                                    try {
                                        if(dimensionAdapter != null){
                                            if(dimensionToList.isEmpty()){
                                                dimensionAdapter.notifyDataSetChanged();
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
                } while (tiresizes.isEmpty() && !stopRetrying);
            }
        };
        new Thread(runnable).start();
    }


    public void getTirethreads(){
        Log.i("onclick", "yeees");
        try{
            tirethreads = APIManager.getTirethreads();
            thread.setHint("Hämtar mönster...");
            threadToList.clear();
            if (!tirethreads.isEmpty()) {
                threadAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, threadToList);
                threadAdapter.notifyDataSetChanged();
                for(Tirethread tirethread : tirethreads){
                    threadAdapter.add(tirethread.getName());
                }
                thread.setHint("Mönster");
                thread.setAdapter(threadAdapter);
                progress.dismiss();
            } else {
                startRefreshtireThread();
            }
        } catch (Exception e){
            Log.i("Post", ""+e);
        }
    }

    public void closeProgress(){
        Log.i("dbcount",DBtablecountInt+"");
        if(DBtablecountInt+1 < totalDBtable){
            Log.i("dbcount+1",DBtablecountInt+"");
            DBtablecountInt = DBtablecountInt+1;
        } else if(DBtablecountInt+1 == totalDBtable){
            DBtablecountInt = DBtablecountInt+1;
            progress.dismiss();
            Log.i("dbcount == 3",DBtablecountInt+"");
            DBtablecountInt = 0;
        }
    }


    private void startRefreshtireThread(){
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
                            thread.setHint("Hämtar mönster...");
                            threadToList.clear();
                            if (!tirethreads.isEmpty()) {
                                threadAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, threadToList);
                                threadAdapter.notifyDataSetChanged();
                                for(Tirethread tirethread : tirethreads){
                                    threadAdapter.add(tirethread.getName());
                                }
                                thread.setAdapter(threadAdapter);
                                thread.setHint("Mönster");
                                progress.dismiss();
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
    }


}
