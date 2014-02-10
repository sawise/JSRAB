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

public class Editorder extends Fragment implements EditText.OnClickListener {

    private EditText deliverydate, comments, customer, total;
    private AutoCompleteTextView thread, dimension;
    private Button setDate, cancelDialog;
    private ImageButton createOrder;
    private DatePicker datePicker;
    ArrayAdapter<String> dimensionAdapter, threadAdapter;
    private String[] dimensionString = new String[] {
            "195/75", "145/65"};
    private String[] threadString = new String[] {
            "195/75", "145/65","195/75", "145/65","195/75", "145/65"};

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.editorder, container, false);

        customer = (EditText) rootView.findViewById(R.id.customer);
        dimension = (AutoCompleteTextView) rootView.findViewById(R.id.dimension);
        thread = (AutoCompleteTextView) rootView.findViewById(R.id.thread);
        deliverydate = (EditText) rootView.findViewById(R.id.deliverydate);
        comments = (EditText) rootView.findViewById(R.id.comments);
        total = (EditText) rootView.findViewById(R.id.total);
        createOrder = (ImageButton) rootView.findViewById(R.id.postOrder);

        customer.setVisibility(View.INVISIBLE);
        dimension.setVisibility(View.INVISIBLE);
        thread.setVisibility(View.INVISIBLE);
        comments.setVisibility(View.INVISIBLE);
        total.setVisibility(View.INVISIBLE);
        createOrder.setVisibility(View.INVISIBLE);
        deliverydate.setText("Du måste välja en order via sök eller veckoöversiken!");



        dimensionAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, dimensionString);
        dimension.setAdapter(dimensionAdapter);

        threadAdapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_dropdown_item_1line, threadString);
        thread.setAdapter(threadAdapter);

        createOrder.setOnClickListener(this);
        deliverydate.setOnClickListener(this);

        return rootView;
    }

    @Override
    public void onResume(){
        super.onResume();
        int orderid = Session.getOrderID();
        if(orderid > 0){
            customer.setVisibility(View.VISIBLE);
            dimension.setVisibility(View.VISIBLE);
            thread.setVisibility(View.VISIBLE);
            comments.setVisibility(View.VISIBLE);
            total.setVisibility(View.VISIBLE);
            createOrder.setVisibility(View.VISIBLE);
            deliverydate.setText("");
        }

    }
    @Override
    public void onClick(View v) {
        if(v == deliverydate){
            dialog();
        } else if(v == createOrder){
            Log.i("Post ID", "" + dimension.getId());
            /*ArrayList<String> arrayList = new ArrayList<String>();
            arrayList.add(deliverydate.getText().toString());
            arrayList.add(customer.getText().toString());
            arrayList.add(dimension.getText().toString());

            arrayList.add(thread.getText().toString());
            arrayList.add(total.getText().toString());
            arrayList.add(comments.getText().toString());
            APIManager.createOrder(getActivity().getApplicationContext(), arrayList);*/
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
