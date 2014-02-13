package com.ex.jsrab.async;

import android.os.AsyncTask;
import android.util.Log;

import com.ex.jsrab.Createorder;
import com.ex.jsrab.Editorder;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by FilipFransson on 2013-12-17.
 */
public class EditOrder extends AsyncTask<String, Void, String> {

    Editorder context;
    ArrayList<String> ordervalue;

    public EditOrder(){
        //this.context = MainActivity;
    }
    public EditOrder(Editorder context, ArrayList<String> ordervalue){
        this.context = context;
        this.ordervalue = ordervalue;
    }

    @Override
    protected String doInBackground(String... urls) {
        return POSTIDENTIFIER(urls[0]);
    }
    @Override
    protected void onPostExecute(String result) {

    }

    public String POSTIDENTIFIER(String url){
        String result = "";
        try {
            HttpParams httpParams = new BasicHttpParams();

            int timeoutConnection = 10000;
            int timeoutSocket = 10000;
            HttpConnectionParams.setConnectionTimeout(httpParams, timeoutConnection);
            HttpConnectionParams.setSoTimeout(httpParams, timeoutSocket);

            HttpClient httpclient = new DefaultHttpClient(httpParams);
            HttpPost httppost = new HttpPost(url);


                List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
                nameValuePairs.add(new BasicNameValuePair("id",ordervalue.get(0).toString()));
                nameValuePairs.add(new BasicNameValuePair("datepicker",ordervalue.get(1).toString() ));
                nameValuePairs.add(new BasicNameValuePair("customer", ordervalue.get(2).toString()));
                nameValuePairs.add(new BasicNameValuePair("dimension", ordervalue.get(3).toString()));
                nameValuePairs.add(new BasicNameValuePair("tirethreads", ordervalue.get(4).toString()));
                nameValuePairs.add(new BasicNameValuePair("total", ordervalue.get(5).toString()));
                nameValuePairs.add(new BasicNameValuePair("notes", ordervalue.get(6).toString()));
                //nameValuePairs.add(new BasicNameValuePair("user_id", "0"));
                httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

                // Execute HTTP Post Request
                HttpResponse response = httpclient.execute(httppost);

            int statusCode = response.getStatusLine().getStatusCode();

            if(statusCode == 200){
                Log.d("com.group2", "Lyckades favorisera");
                return "true";
            } else if(statusCode == 400 || statusCode == 401 || statusCode == 404 || statusCode == 500){
                Log.d("com.group2", "Misslyckades med att favorisera, felkod: " + statusCode + " identifier: ");
                //Toast.makeText(context, "Failed to favorized", 1000).show();
                return "false";
            }

        } catch (Exception e) {
            Log.d("InputStream", e.getLocalizedMessage());
            result = "Did not work!";
        }

        return result;
    }
}
