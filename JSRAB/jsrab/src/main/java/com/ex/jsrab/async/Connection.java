package com.ex.jsrab.async;

import android.app.Activity;
import android.content.Context;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.Toast;

import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.client.methods.HttpPut;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;

/**
 * Created by FilipFransson on 2013-12-04.
 */

public class Connection {
    private Context context;
    private int id;

    public Connection(Context context, int drinkId  ){
        this.context = context;
        this.id = drinkId;

    }

    public void PutJsonUp(){
        new HttpAsyncTask().execute("http://dev2-vyh.softwerk.se:8080/bottomAppServer/json/drinks/"+id+"/ratingup");
    }

    public  void PutJsonDown() {
        new HttpAsyncTask().execute("http://dev2-vyh.softwerk.se:8080/bottomAppServer/json/drinks/"+id+"/ratingdown");
    }

    public static String Rating(String url){
        InputStream inputStream = null;
        String result = "";
        try {

            HttpClient httpclient = new DefaultHttpClient();
            HttpPut httpPut = new HttpPut(url);

            httpPut.setHeader("Accept", "application/json");
            httpPut.setHeader("Authorization", "apikey='1c9fk3u35ldcefgw'");
            httpPut.setHeader("Content-type", "application/json");

            HttpResponse httpResponse = httpclient.execute(httpPut);

            inputStream = httpResponse.getEntity().getContent();

            if(inputStream != null)
                result = convertInputStreamToString(inputStream);
            else
                result = "Did not work!";

        } catch (Exception e) {
            Log.d("InputStream", e.getLocalizedMessage());
            result = "Did not work!";
        }

        return result;
    }

    public boolean isConnected(){
        ConnectivityManager connMgr = (ConnectivityManager) context.getSystemService(Activity.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = connMgr.getActiveNetworkInfo();
        if (networkInfo != null && networkInfo.isConnected())
            return true;
        else
            return false;
    }

    private class HttpAsyncTask extends AsyncTask<String, Void, String> {
        @Override
        protected String doInBackground(String... urls) {

            return Rating(urls[0]);
        }
        // onPostExecute displays the results of the AsyncTask.
        @Override
        protected void onPostExecute(String result) {
            if(result.contains("Drink rating updated!")){
                Toast.makeText(context, "Drink rating updated!", Toast.LENGTH_SHORT);
            } else if(result.contains("Internal error, The User could not be added!")){
                // TODO send feedback and request them to retry
                Toast.makeText(context, "", Toast.LENGTH_SHORT);
            } else if(result.contains("Did not work!")){
                Toast.makeText(context, "Drink not found!", Toast.LENGTH_SHORT);
            }
        }
    }

    private static String convertInputStreamToString(InputStream inputStream) throws IOException {
        BufferedReader bufferedReader = new BufferedReader( new InputStreamReader(inputStream));
        String line = "";
        String result = "";
        while((line = bufferedReader.readLine()) != null)
            result += line;

        inputStream.close();
        return result;

    }
}

