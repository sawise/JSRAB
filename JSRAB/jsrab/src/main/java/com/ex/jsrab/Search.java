package com.ex.jsrab;


import android.app.Dialog;
import android.app.ProgressDialog;
import android.graphics.Color;
import android.graphics.drawable.BitmapDrawable;
import android.os.AsyncTask;
import android.os.Bundle;
import android.os.Handler;
import android.support.v4.app.Fragment;
import android.text.Layout;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TableLayout;
import android.widget.TableRow;
import android.widget.TextView;
import android.widget.Toast;

import com.ex.jsrab.async.CreateOrderPOST;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.util.EntityUtils;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.lang.reflect.Array;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

public class Search extends Fragment implements View.OnClickListener, ListView.OnItemClickListener {
    private ArrayAdapter<Searchresult> adapter;
    private List<Searchresult> data = new ArrayList<Searchresult>();
    private ArrayList<Searchresult> datatoList;
    private ListView searchresult;
    private EditText searchText;
    private Button searchButton;
    private String searchString = "";
    private String tireThread = "nothread";
    private String tireSize = "nosize";
    private String dateStart = "nodate";
    private String dateEnd = "";
    private ProgressDialog progress;
    private int allowedRetries = 10;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        View rootView = inflater.inflate(R.layout.searchtest, container, false);

        searchresult = (ListView) rootView.findViewById(R.id.searchresult);
        searchText = (EditText) rootView.findViewById(R.id.searchText);
        searchButton = (Button) rootView.findViewById(R.id.searchButton);

        datatoList = new ArrayList<Searchresult>();

        progress = new ProgressDialog(getActivity());
        progress.setTitle("Loading");
        progress.setMessage("Please wait...");


        searchresult.setOnItemClickListener(this);
        searchButton.setOnClickListener(this);
        return rootView;
    }


    @Override
    public void onClick(View v) {
        if(v == searchButton){
            Log.i("onclick","yeees");
            searchString = searchText.getText().toString();
            progress.show();
           try{
               data.clear();
               data = APIManager.getSearchresults(searchString);
               //adapter = new ArrayAdapter<String>(this.getActivity(), R.layout.custom_list_item, datatoList);
               if(!data.isEmpty()) {
                   adapter = new CustomSearchAdapter(this.getActivity(), R.layout.customsearch, datatoList);
                   if(!adapter.isEmpty()){
                       adapter.clear();
                   }
                   searchresult.setAdapter(adapter);
                   //APIManager.updateSearch();
                   for(Searchresult searchdata : data){
                           Searchresult stringToAdd = new Searchresult(searchdata.getId(),searchdata.getDate() ,searchdata.getCustomerName() ,searchdata.getTirethreadName(), searchdata.getTiresizeName(), searchdata.getComments(), searchdata.getTotal());
                           //String stringToAdd = "Leveransdatum: "+searchdata.getDate()+"\n"+"Kund: "+searchdata.getCustomerName()+"\n"+"Mönster: "+searchdata.getTirethreadName()+"\n"+"Dimension: "+searchdata.getTiresizeName()+"\n"+"Totalt: "+searchdata.getTotal();
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
                            data = APIManager.getSearchresults(searchString);
                            adapter = new CustomSearchAdapter(getActivity(), R.layout.customsearch, datatoList);
                            if (!data.isEmpty()) {
                                adapter.clear();
                                for(Searchresult searchdata : data){
                                    Searchresult stringToAdd = new Searchresult(searchdata.getId(),searchdata.getDate() ,searchdata.getCustomerName() ,searchdata.getTirethreadName(), searchdata.getTiresizeName(), searchdata.getComments(), searchdata.getTotal());
                                    //String stringToAdd = "Leveransdatum: "+searchdata.getDate()+"\n"+"Kund: "+searchdata.getCustomerName()+"\n"+"Mönster: "+searchdata.getTirethreadName()+"\n"+"Dimension: "+searchdata.getTiresizeName()+"\n"+"Totalt: "+searchdata.getTotal();
                                    adapter.add(stringToAdd);
                                }
                                searchresult.setAdapter(adapter);
                                progress.dismiss();
                            } else {
                                Log.i("retry...", "yes o.O");
                                retries++;
                                if(retries < allowedRetries){
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

    @Override
    public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
        if(parent == searchresult){
            int itemid = data.get(position).getId();
            dialog(itemid, data.get(position));
            //selectedItem = position;
            //String text = gridArray.get(position).getName();
            //String category = gridArray.get(position).getCategoryName();
            //int imageId = gridArray.get(position).getImageId();

            //dialog(category,gridArray.get(position).imageResourceId, text);
        }
    }

    public void dialog(int id, Searchresult searchitem){
        final Dialog dialog = new Dialog(getActivity());
        dialog.setContentView(R.layout.searchresultdialog);
        dialog.setTitle("text");
        dialog.setCancelable(true);

        TextView dialogText = (TextView) dialog.findViewById(R.id.dialogText);
        Button removeButton = (Button) dialog.findViewById(R.id.buttonRemove);
        Button cancelButton = (Button) dialog.findViewById(R.id.buttonCancel);

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
        String dialogTextStr = "Leveransdatum: "+searchitem.getDate()+"\n"+"Kund: "+searchitem.getCustomerName()+"\n"+"Mönster: "+searchitem.getTirethreadName()+"\n"+"Dimension: "+searchitem.getTiresizeName()+"\n"+"Totalt: "+searchitem.getTotal()+"\nKommentarer: "+searchitem.getComments();
        dialogText.setText(dialogTextStr);

        dialog.show();

    }

}
