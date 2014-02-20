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

public class Editorder extends Fragment implements EditText.OnClickListener {

    private EditText deliverydate, comments, total;
    private TextView noEdittext, editorderID;
    private AutoCompleteTextView thread, dimension, customer;
    private Button cancelDialog;
    private ImageButton editOrder;
    private DatePicker datePicker;
    private List<Searchresult> data = new ArrayList<Searchresult>();
    private String searchString;
    private ProgressDialog progress;
    private String tireThread = "nothread";
    private String tireSize = "nosize";
    private String dateStart = "nodate";
    private String dateEnd = "";

    private ArrayList<String> customerToList = new ArrayList<String>();
    private ArrayList<String> dimensionToList = new ArrayList<String>();
    private ArrayList<String> threadToList = new ArrayList<String>();
    private ArrayAdapter<String> customerAdapter, threadAdapter, dimensionAdapter;

    private ArrayList<Tiresize> tiresizes;
    private ArrayList<Tirethread> tirethreads;
    private ArrayList<Customer> customers;
    private int orderid = 0;
    private MenuItem refresh;
    private int totalDBtable = 3;
    private int DBtablecountInt = 0;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.editorder, container, false);
        setHasOptionsMenu(true);

        noEdittext = (TextView) rootView.findViewById(R.id.noEdittext);
        editorderID = (TextView) rootView.findViewById(R.id.editorderID);
        customer = (AutoCompleteTextView) rootView.findViewById(R.id.editOrdercustomer);
        dimension = (AutoCompleteTextView) rootView.findViewById(R.id.editOrderdimension);
        thread = (AutoCompleteTextView) rootView.findViewById(R.id.editOrderthread);
        deliverydate = (EditText) rootView.findViewById(R.id.editOrderdeliverydate);
        comments = (EditText) rootView.findViewById(R.id.editOrdercomments);
        total = (EditText) rootView.findViewById(R.id.editOrdertotal);
        editOrder = (ImageButton) rootView.findViewById(R.id.postEditorder);

        Log.i("user id", Session.getUserIdStr());

        progress = new ProgressDialog(getActivity());
        progress.setMessage("Hämtar ordern...");

        noEdittext.setVisibility(View.VISIBLE);
        customer.setVisibility(View.INVISIBLE);
        dimension.setVisibility(View.INVISIBLE);
        thread.setVisibility(View.INVISIBLE);
        comments.setVisibility(View.INVISIBLE);
        total.setVisibility(View.INVISIBLE);
        editOrder.setVisibility(View.INVISIBLE);
        deliverydate.setVisibility(View.INVISIBLE);



        editOrder.setOnClickListener(this);
        deliverydate.setOnClickListener(this);

        return rootView;
    }

    @Override
    public void onCreateOptionsMenu(Menu menu, MenuInflater inflater) {
        inflater.inflate(R.menu.editorder, menu);
        super.onCreateOptionsMenu(menu, inflater);
        refresh = (MenuItem) menu.findItem(R.id.refreshedit);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.refreshedit:
                if(orderid == 0){
                    Toast.makeText(getActivity(), "Du måste välja en order via sök eller veckoöversikten", Toast.LENGTH_LONG).show();
                } else {
                    getOrder();
                }
                return true;
            default:
                break;
        }
        return false;
    }




    @Override
    public void onResume(){
        super.onResume();
        getOrder();
    }

    @Override
    public void onClick(View v) {
        if(v == deliverydate){
            dialog();
        } else if(v == editOrder){
            Log.i("Post ID", Session.getUserIdStr()+"<->"+orderid);
            ArrayList<String> arrayList = new ArrayList<String>();
            arrayList.add(Integer.toString(orderid));
            arrayList.add(deliverydate.getText().toString());
            arrayList.add(customer.getText().toString());
            arrayList.add(dimension.getText().toString());
            arrayList.add(thread.getText().toString());
            arrayList.add(total.getText().toString());
            arrayList.add(comments.getText().toString());
            arrayList.add(Session.getUserIdStr());
            APIManager.editOrder(getActivity(), arrayList);
        }

        //post.execute((Void) null);
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
                // TODO Auto-generated method stub
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

    public void getOrder(){
        orderid = Session.getOrderID();
        searchString = "id_"+orderid;

        if(orderid > 0){
            progress.show();
            customer.setVisibility(View.VISIBLE);
            dimension.setVisibility(View.VISIBLE);
            thread.setVisibility(View.VISIBLE);
            comments.setVisibility(View.VISIBLE);
            total.setVisibility(View.VISIBLE);
            editOrder.setVisibility(View.VISIBLE);
            deliverydate.setVisibility(View.VISIBLE);
            noEdittext.setVisibility(View.GONE);
            try{
                data.clear();
                data = APIManager.getSearchresults(searchString, tireThread, tireSize, dateStart, dateEnd);
                if(!data.isEmpty()) {
                    customer.setText(data.get(0).getCustomerName());
                    deliverydate.setText(data.get(0).getDeliverydate());
                    dimension.setText(data.get(0).getTiresizeName());
                    thread.setText(data.get(0).getTirethreadName());
                    comments.setText(data.get(0).getComments());
                    total.setText(""+data.get(0).getTotal());

                    //getCustomers();
                    customers = APIManager.customers;
                    customerToList.clear();
                    customerAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, customerToList);
                    for(Customer customer : customers){
                        customerAdapter.add(customer.getName());
                    }
                    customer.setAdapter(customerAdapter);
                    tiresizes = APIManager.tiresizes;
                    dimensionToList.clear();
                        dimensionAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, dimensionToList);
                        dimensionAdapter.notifyDataSetChanged();
                        for(Tiresize tiresize : tiresizes){
                            dimensionAdapter.add(tiresize.getName());
                        }
                        dimension.setAdapter(dimensionAdapter);
                    progress.dismiss();
                    Session.setOrderID(0);
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

                            data = APIManager.getSearchresults(searchString, tireThread, tireSize, dateStart, dateEnd);

                            if (!data.isEmpty()) {
                                customer.setText(data.get(0).getCustomerName());
                                deliverydate.setText(data.get(0).getDeliverydate());
                                dimension.setText(data.get(0).getTiresizeName());
                                thread.setText(data.get(0).getTirethreadName());
                                comments.setText(data.get(0).getComments());
                                total.setText(""+data.get(0).getTotal());
                                getCustomers();
                               /* customers = APIManager.customers;
                                customerToList.clear();
                                    customerAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, customerToList);
                                for(Customer customer : customers){
                                    customerAdapter.add(customer.getName());
                                }
                                customer.setAdapter(customerAdapter);
                                tiresizes = APIManager.tiresizes;
                                dimensionToList.clear();
                                dimensionAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, dimensionToList);
                                dimensionAdapter.notifyDataSetChanged();
                                for(Tiresize tiresize : tiresizes){
                                    dimensionAdapter.add(tiresize.getName());
                                }
                                dimension.setAdapter(dimensionAdapter);
                                progress.dismiss();*/
                                Session.setOrderID(0);
                            } else {
                                Log.i("retry...", "yes o.O");
                                retries++;
                                if(retries < HelperFunctions.allowedRetries){
                                    stopRetrying = true;
                                }
                            }
                        }
                    });
                } while (data.isEmpty() && !stopRetrying);
            }
        };
        new Thread(runnable).start();
    }

    public void getCustomers(){
        Log.i("onclick", "yeees");

        try{
            //customers = APIManager.getCustomers();
            customers = APIManager.customers;
            customerToList.clear();
            if (!customers.isEmpty()) {
                customerAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, customerToList);
                customerAdapter.notifyDataSetChanged();
                for(Customer customer : customers){
                    customerAdapter.add(customer.getName());
                }
                customer.setAdapter(customerAdapter);
                //closeProgress();
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
                            //customers = APIManager.getCustomers();
                            customers = APIManager.customers;
                            customerToList.clear();
                            if (!customers.isEmpty()) {
                                customerAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, customerToList);
                                customerAdapter.notifyDataSetChanged();
                                for(Customer customer : customers){
                                    customerAdapter.add(customer.getName());
                                }

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
            //tiresizes = APIManager.getTiresizes();
            tiresizes = APIManager.tiresizes;
            dimensionToList.clear();
            if (!tiresizes.isEmpty()) {
                dimensionAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, dimensionToList);
                dimensionAdapter.notifyDataSetChanged();
                for(Tiresize tiresize : tiresizes){
                    dimensionAdapter.add(tiresize.getName());
                }
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
                            //tiresizes = APIManager.getTiresizes();
                            tiresizes = APIManager.tiresizes;
                            dimensionToList.clear();
                            if (!tiresizes.isEmpty()) {
                                dimensionAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, dimensionToList);
                                dimensionAdapter.notifyDataSetChanged();
                                for(Tiresize tiresize : tiresizes){
                                    dimensionAdapter.add(tiresize.getName());
                                }
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
            //tirethreads = APIManager.getTirethreads();
            tirethreads = APIManager.tirethreads;
            threadToList.clear();
            if (!tirethreads.isEmpty()) {
                threadAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, threadToList);
                threadAdapter.notifyDataSetChanged();
                for(Tirethread tirethread : tirethreads){
                    threadAdapter.add(tirethread.getName());
                }
                thread.setAdapter(threadAdapter);
                progress.dismiss();
            } else {
                startRefreshtireThread();
            }
        } catch (Exception e){
            Log.i("Post", ""+e);
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
                            //tirethreads = APIManager.getTirethreads();
                            tirethreads = APIManager.tirethreads;
                            threadToList.clear();
                            if (!tirethreads.isEmpty()) {
                                threadAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, threadToList);
                                threadAdapter.notifyDataSetChanged();
                                for(Tirethread tirethread : tirethreads){
                                    threadAdapter.add(tirethread.getName());
                                }
                                thread.setAdapter(threadAdapter);
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
