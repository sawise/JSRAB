package com.ex.jsrab;


import android.graphics.Color;
import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.text.Layout;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ListView;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;

import java.util.ArrayList;
import java.util.List;

public class Search extends Fragment {
    private ArrayAdapter<String> adapter;
    private List<String> data;
    private ListView searchresult;
    private String[] rows;


    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.searchtest, container, false);

        searchresult = (ListView) rootView.findViewById(R.id.searchresult);

        data = new ArrayList<String>();
        adapter = new ArrayAdapter<String>(this.getActivity(), R.layout.custom_list_item, data);
        searchresult.setAdapter(adapter);
        for(int i = 0; i < 20; i++){
            addTableRow(rootView, inflater, "row"+i);
            adapter.add("Leveransdatum: 2014-03-28"+"\n"+"Kund: Sams Däck AB"+"\n"+"Mönster: B104"+"\n"+"Dimension: 10.00-20"+"\n"+"Totalt: 10");

        }
        return rootView;
    }

    private void addTableRow(View rootView, LayoutInflater inflater, String text) {
        /*final TableLayout table = (TableLayout) rootView.findViewById(R.id.searchtable);
        final TableRow tr = (TableRow) inflater.inflate(R.layout.tablerow, null);

        TextView tv;
        // Fill out our cells
        tv = (TextView) tr.findViewById(R.id.cell1);
        tv.setText("2014-03-28");
        tv = (TextView) tr.findViewById(R.id.cell2);
        tv.setText("Sams Däck AB");

        tv = (TextView) tr.findViewById(R.id.cell3);
        tv.setText("B104");
        tv = (TextView) tr.findViewById(R.id.cell4);
        tv.setText("10.00-20");

        tv = (TextView) tr.findViewById(R.id.cell5);
        tv.setText("10");

        tv = (TextView) tr.findViewById(R.id.cell6);
        tv.setText("");

        table.addView(tr);



        // If you use context menu it should be registered for each table row
        registerForContextMenu(tr);
*/

    }

}
