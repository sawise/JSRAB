package com.ex.jsrab;


import android.app.Dialog;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;

public class Createorder extends Fragment implements EditText.OnClickListener {

    private EditText deliverydate;
    private Button setDate, cancelDialog;
    private DatePicker datePicker;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.createorder, container, false);

        deliverydate = (EditText) rootView.findViewById(R.id.deliverydate);
        deliverydate.setOnClickListener(this);

        return rootView;
    }
    @Override
    public void onClick(View v) {
        if(v == deliverydate){
            dialog();
        }
    }



    public void dialog(){
        final Dialog dialog = new Dialog(getActivity());
        dialog.setContentView(R.layout.createorderdialog);
        dialog.setTitle("Välj vecka");
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


}
