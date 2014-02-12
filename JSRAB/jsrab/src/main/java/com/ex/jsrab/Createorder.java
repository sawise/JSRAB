package com.ex.jsrab;


import android.app.Dialog;
import android.os.Bundle;
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
import android.widget.Toast;

import java.util.ArrayList;
import java.util.List;

public class Createorder extends Fragment implements EditText.OnClickListener {

    private EditText deliverydate, comments, customer, total;
    public static TextView toast;
    private AutoCompleteTextView thread, dimension;
    private Button setDate, cancelDialog;
    private ImageButton createOrder;
    private DatePicker datePicker;
    ArrayAdapter<Tirethread> threadAdapter;
    ArrayAdapter<Tiresize> dimensionAdapter;
    private ArrayList<Tiresize> tiresizes;
    private ArrayList<Tirethread> tirethreads;
    private List<Searchresult> data = new ArrayList<Searchresult>();
    private ArrayList<Searchresult> datatoList;
    private View rootView;



    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.createorder, container, false);

        toast = (TextView) rootView.findViewById(R.id.toast);
        toast.setText("fungerar..... not!");
        customer = (EditText) rootView.findViewById(R.id.customer);
        dimension = (AutoCompleteTextView) rootView.findViewById(R.id.dimension);
        thread = (AutoCompleteTextView) rootView.findViewById(R.id.thread);
        deliverydate = (EditText) rootView.findViewById(R.id.deliverydate);
        comments = (EditText) rootView.findViewById(R.id.comments);
        total = (EditText) rootView.findViewById(R.id.total);
        createOrder = (ImageButton) rootView.findViewById(R.id.postOrder);

        /*tiresizes = APIManager.getTiresizes();
        tirethreads = APIManager.getTirethreads();

        dimensionAdapter = new ArrayAdapter<Tiresize>(getActivity(), android.R.layout.simple_dropdown_item_1line, tiresizes);
        dimension.setAdapter(dimensionAdapter);

        threadAdapter = new ArrayAdapter<Tirethread>(getActivity(), android.R.layout.simple_dropdown_item_1line, tirethreads);
        thread.setAdapter(threadAdapter);*/

        createOrder.setOnClickListener(this);
        deliverydate.setOnClickListener(this);

        return rootView;
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
            APIManager.createOrder(this, arrayList);
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



}
