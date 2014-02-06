package com.ex.jsrab.async;

import android.content.Context;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.Toast;

import com.ex.jsrab.HelperFunctions;
import com.ex.jsrab.MainActivity;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONObject;

import java.io.InputStream;
import java.util.ArrayList;
import java.util.List;

/**
 * Created by FilipFransson on 2013-12-17.
 */
public class CreateOrder extends AsyncTask<String, Void, String> {

    Context context;
    ArrayList<String> ordervalue;

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
    protected void onPostExecute(String result) {

    }

    public String POSTIDENTIFIER(String url){
        String result = "";
        try {

            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httppost = new HttpPost(url);

                List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
                nameValuePairs.add(new BasicNameValuePair("datepicker",ordervalue.get(0).toString() ));
                nameValuePairs.add(new BasicNameValuePair("customer", ordervalue.get(1).toString()));
                nameValuePairs.add(new BasicNameValuePair("dimension", ordervalue.get(2).toString()));
                nameValuePairs.add(new BasicNameValuePair("tirethreads", ordervalue.get(3).toString()));
                nameValuePairs.add(new BasicNameValuePair("total", ordervalue.get(4).toString()));
                nameValuePairs.add(new BasicNameValuePair("notes", ordervalue.get(5).toString()));
                nameValuePairs.add(new BasicNameValuePair("user_id", "0"));
                httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

                // Execute HTTP Post Request
                HttpResponse response = httpclient.execute(httppost);

            int statusCode = response.getStatusLine().getStatusCode();

            if(statusCode == 200){
                Log.d("com.group2", "Lyckades favorisera");
                Toast.makeText(context.getApplicationContext(), "blablabla", Toast.LENGTH_LONG).show();
                //Toast.makeText(context, "Favorized ", 1000).show();
                return "true";
            } else if(statusCode == 400 || statusCode == 401 || statusCode == 404 || statusCode == 500){
               // Log.d("com.group2", "Misslyckades med att favorisera, felkod: " + statusCode + " identifier: " + HelperClass.User.userIdentifier);
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
