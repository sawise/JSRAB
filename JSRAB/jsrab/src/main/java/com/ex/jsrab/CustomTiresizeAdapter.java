package com.ex.jsrab;

/**
 * Created by sam on 12/17/13.
 */

import android.app.Activity;
import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.TextView;

import java.util.ArrayList;

public class CustomTiresizeAdapter extends ArrayAdapter<Searchresult> {
    Context context;

    int layoutResourceId;

    ArrayList<Searchresult> data = new ArrayList<Searchresult>();



    public CustomTiresizeAdapter(Context context, int layoutResourceId, ArrayList<Searchresult> data) {
        super(context, layoutResourceId, data);
        this.layoutResourceId = layoutResourceId;
        this.context = context;
        this.data = data;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        View row = convertView;
        RecordHolder holder = null;
        if (row == null) {
            LayoutInflater inflater = ((Activity) context).getLayoutInflater();

            row = inflater.inflate(layoutResourceId, parent, false);
            holder = new RecordHolder();
            holder.id = (TextView) row.findViewById(R.id.id);
            holder.searchResult = (TextView) row.findViewById(R.id.item_text);
            
            row.setTag(holder);
        } else {
            holder = (RecordHolder) row.getTag();
        }
        Searchresult item = data.get(position);

        String id = Integer.toString(item.getId());
        String stringToAdd = "Leveransdatum: "+item.getDate()+"\n"+"Kund: "+item.getCustomerName()+"\n"+"Mönster: "+item.getTirethreadName()+"\n"+"Dimension: "+item.getTiresizeName()+"\n"+"Totalt: "+item.getTotal();
        holder.searchResult.setText(id);
        holder.searchResult.setText(stringToAdd);

        return row;

    }

    static class RecordHolder {
        TextView id;
        TextView searchResult;
    }


}
