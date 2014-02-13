package com.ex.jsrab.async;

import android.app.ProgressDialog;
import android.content.Context;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.Toast;

import com.ex.jsrab.Createorder;
import com.ex.jsrab.HelperFunctions;
import com.ex.jsrab.MainActivity;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.conn.ConnectTimeoutException;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.HttpConnectionParams;
import org.apache.http.params.HttpParams;
import org.json.JSONObject;

import java.io.InputStream;
import java.net.SocketTimeoutException;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by FilipFransson on 2013-12-17.
 */
public class CreateOrder extends AsyncTask<String, Void, String> {

    Context context;
    ArrayList<String> ordervalue;
    ProgressDialog progress;

    public CreateOrder(){
        //this.context = MainActivity;
    }
    public CreateOrder(Context context, ArrayList<String> ordervalue){
        this.context = context;
        this.ordervalue = ordervalue;

    }

    @Override
    protected String doInBackground(String... urls) {
        return POSTIDENTIFIER(urls[0]);
    }
    @Override
    protected void onPreExecute() {
        progress = new ProgressDialog(context);
        progress.setTitle("");
        progress.setMessage("Sparar informationen...");
        progress.show();
    }

    @Override
    protected void onPostExecute(String result) {
        progress.dismiss();
        Toast.makeText(context, "Ordern är skapad, gå till sök för att hitta den", Toast.LENGTH_LONG).show();
    }

    public String POSTIDENTIFIER(String url){
        String result = "";
        try {
            HttpParams httpParams = new BasicHttpParams();

            int timeoutConnection = 3000;
            int timeoutSocket = 5000;
            HttpConnectionParams.setConnectionTimeout(httpParams, timeoutConnection);
            HttpConnectionParams.setSoTimeout(httpParams, timeoutSocket);

            HttpClient httpclient = new DefaultHttpClient(httpParams);
            HttpPost httppost = new HttpPost(url);


                List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
                nameValuePairs.add(new BasicNameValuePair("datepicker",ordervalue.get(0).toString() ));
                nameValuePairs.add(new BasicNameValuePair("customer", ordervalue.get(1).toString()));
                nameValuePairs.add(new BasicNameValuePair("dimension", ordervalue.get(2).toString()));
                nameValuePairs.add(new BasicNameValuePair("tirethreads", ordervalue.get(3).toString()));
                nameValuePairs.add(new BasicNameValuePair("total", ordervalue.get(4).toString()));
                nameValuePairs.add(new BasicNameValuePair("notes", ordervalue.get(5).toString()));
                nameValuePairs.add(new BasicNameValuePair("user_id", ordervalue.get(6).toString()));
                httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

                // Execute HTTP Post Request
                HttpResponse response = httpclient.execute(httppost);



            int statusCode = response.getStatusLine().getStatusCode();

            if(statusCode == 200){
                Log.d("com.group2", "Lyckades favorisera");
                //Createorder.toast.setText("Ordern skapades! :)");
                //Toast.makeText(context.setToast(""), "Favorized ", 1000).show();
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
