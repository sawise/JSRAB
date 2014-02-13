package com.ex.jsrab;


import android.app.Dialog;
import android.app.ProgressDialog;
import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.AutoCompleteTextView;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

public class Editorder extends Fragment implements EditText.OnClickListener {

    private EditText deliverydate, comments, customer, total;
    private TextView noEdittext, editorderID;
    private AutoCompleteTextView thread, dimension;
    private Button setDate, cancelDialog;
    private ImageButton editOrder;
    private DatePicker datePicker;
    ArrayAdapter<String> dimensionAdapter, threadAdapter;
    private String[] dimensionString = new String[] {
            "195/75", "145/65"};
    private String[] threadString = new String[] {
            "195/75", "145/65","195/75", "145/65","195/75", "145/65"};
    private List<Searchresult> data = new ArrayList<Searchresult>();
    private String searchString;
    private ProgressDialog progress;
    private String tireThread = "nothread";
    private String tireSize = "nosize";
    private String dateStart = "nodate";
    private String dateEnd = "";

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.editorder, container, false);


        noEdittext = (TextView) rootView.findViewById(R.id.noEdittext);
        editorderID = (TextView) rootView.findViewById(R.id.editorderID);
        customer = (EditText) rootView.findViewById(R.id.editOrdercustomer);
        dimension = (AutoCompleteTextView) rootView.findViewById(R.id.editOrderdimension);
        thread = (AutoCompleteTextView) rootView.findViewById(R.id.editOrderthread);
        deliverydate = (EditText) rootView.findViewById(R.id.editOrderdeliverydate);
        comments = (EditText) rootView.findViewById(R.id.editOrdercomments);
        total = (EditText) rootView.findViewById(R.id.editOrdertotal);
        editOrder = (ImageButton) rootView.findViewById(R.id.postEditorder);

        progress = new ProgressDialog(getActivity());
        progress.setTitle("Loading");
        progress.setMessage("Please wait...");

        noEdittext.setVisibility(View.VISIBLE);
        customer.setVisibility(View.INVISIBLE);
        dimension.setVisibility(View.INVISIBLE);
        thread.setVisibility(View.INVISIBLE);
        comments.setVisibility(View.INVISIBLE);
        total.setVisibility(View.INVISIBLE);
        editOrder.setVisibility(View.INVISIBLE);
        deliverydate.setVisibility(View.INVISIBLE);

        /*dimensionAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, dimensionString);
        dimension.setAdapter(dimensionAdapter);

        threadAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, threadString);
        thread.setAdapter(threadAdapter);*/

        editOrder.setOnClickListener(this);
        deliverydate.setOnClickListener(this);

        return rootView;
    }

    @Override
    public void onResume(){
        super.onResume();
        int orderid = Session.getOrderID();
        Session.setOrderID(0);
        searchString = "id_"+orderid;
        if(orderid > 0){
            customer.setVisibility(View.VISIBLE);
            dimension.setVisibility(View.VISIBLE);
            thread.setVisibility(View.VISIBLE);
            comments.setVisibility(View.VISIBLE);
            total.setVisibility(View.VISIBLE);
            editOrder.setVisibility(View.VISIBLE);
            deliverydate.setVisibility(View.VISIBLE);
            noEdittext.setVisibility(View.GONE);
            getOrder();
        }
    }

    @Override
    public void onClick(View v) {
        if(v == deliverydate){
            dialog();
        } else if(v == editOrder){
            Log.i("Post ID", "" + dimension.getId());
            ArrayList<String> arrayList = new ArrayList<String>();
            arrayList.add(searchString);
            arrayList.add(deliverydate.getText().toString());
            arrayList.add(customer.getText().toString());
            arrayList.add(dimension.getText().toString());
            arrayList.add(thread.getText().toString());
            arrayList.add(total.getText().toString());
            arrayList.add(comments.getText().toString());
            APIManager.editOrder(this, arrayList);
        }

        //post.execute((Void) null);
    }

    public void dialog(){
        final Dialog dialog = new Dialog(getActivity());
        dialog.setContentView(R.layout.createorderdialog);
        dialog.setTitle("Välj datum");
        dialog.setCancelable(true);
        cancelDialog = (Button) dialog.findViewById(R.id.closeDialogCreateOrder);
        setDate = (Button) dialog.findViewById(R.id.setDateCreateOrder);
        datePicker = (DatePicker) dialog.findViewById(R.id.datePickerCreateOrder);
        setDate.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                int y = datePicker.getYear();
                int m = datePicker.getMonth();
                int d = datePicker.getDayOfMonth();
                deliverydate.setText(HelperFunctions.dateToString(y,m,d));
                dialog.dismiss();
                return;
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

    public void getOrder(){
        try{
            data.clear();
            data = APIManager.getSearchresults(searchString, tireThread, tireSize, dateStart, dateEnd);
            if(!data.isEmpty()) {
                for(Searchresult searchdata : data){
                    editorderID.setText(searchdata.getId());
                    deliverydate.setText(searchdata.getDeliverydate());
                    dimension.setText(searchdata.getTiresizeName());
                    thread.setText(searchdata.getTirethreadName());
                    comments.setText(searchdata.getComments());
                    total.setText(Integer.toString(searchdata.getTotal()));
                    customer.setText(searchdata.getCustomerName());
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
                            data = APIManager.getSearchresults(searchString, tireThread, tireSize, dateStart, dateEnd);

                            if (!data.isEmpty()) {
                                customer.setText(data.get(0).getCustomerName());
                                for(Searchresult searchdata : data){

                                    deliverydate.setText(searchdata.getDeliverydate());
                                    dimension.setText(searchdata.getTiresizeName());
                                    thread.setText(searchdata.getTirethreadName());
                                    comments.setText(searchdata.getComments());
                                    total.setText(""+searchdata.getTotal());
                                    customer.setText(searchdata.getCustomerName());
                                }
                                progress.dismiss();
                            } else {
                                Log.i("retry...", "yes o.O");
                                retries++;
                                if(retries < HelperFunctions.allowedRetries){
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
