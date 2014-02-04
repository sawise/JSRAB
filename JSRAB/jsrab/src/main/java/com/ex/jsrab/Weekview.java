package com.ex.jsrab;


import android.app.Dialog;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.DatePicker;
import android.widget.EditText;
import android.widget.ListView;

import java.text.DateFormatSymbols;
import java.util.ArrayList;
import java.util.Calendar;
import java.util.List;

public class Weekview extends Fragment implements EditText.OnClickListener {

    private ArrayAdapter<String> adapter;
    private List<String> data;
    private ListView weeklistview;
    private EditText week;
    private Button setDate, cancelDialog;
    private DatePicker datePicker;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.weekview, container, false);
        setHasOptionsMenu(true);

        week = (EditText) rootView.findViewById(R.id.week);
        weeklistview = (ListView) rootView.findViewById(R.id.weeklistview);
        data = new ArrayList<String>();
        adapter = new ArrayAdapter<String>(this.getActivity(), R.layout.custom_list_item, data);
        weeklistview.setAdapter(adapter);
        for(int i = 0; i < 20; i++){
            adapter.add("Leveransdatum: 2014-03-28"+"\n"+"Kund: Sams Däck AB"+"\n"+"Mönster: B104"+"\n"+"Dimension: 10.00-20"+"\n"+"Totalt: 10");

        }

        week.setOnClickListener(this);
        return rootView;
    }

    @Override
    public void onCreateOptionsMenu(Menu menu, MenuInflater inflater) {
        inflater.inflate(R.menu.drinkmenu, menu);
        super.onCreateOptionsMenu(menu, inflater);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        /*switch (item.getItemId()) {
            case R.id.cl:

                return true;
            case R.id.oz:

                return true;
            case R.id.starInMenu:

            default:
                break;
        }*/
        return false;
    }

    public void dialog(){
        final Dialog dialog = new Dialog(getActivity());
        dialog.setContentView(R.layout.searchyeardialog);
        dialog.setTitle("Välj vecka");
        cancelDialog = (Button) dialog.findViewById(R.id.closeDialog);
        setDate = (Button) dialog.findViewById(R.id.setDate);
        datePicker = (DatePicker) dialog.findViewById(R.id.datePicker);


        setDate.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Calendar choosenDate  = Calendar.getInstance();
                int y = datePicker.getYear();
                int m = datePicker.getMonth();
                int d = datePicker.getDayOfMonth();
                choosenDate.set(y, m, d);
                int weeknumber = choosenDate.get(Calendar.WEEK_OF_YEAR);
                week.setText("År:"+y+" Månad:"+HelperFunctions.getMonthForInt(m)+" Vecka:"+weeknumber);
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


    @Override
    public void onClick(View v) {
        if(v == week){
            dialog();
        }
    }
}
