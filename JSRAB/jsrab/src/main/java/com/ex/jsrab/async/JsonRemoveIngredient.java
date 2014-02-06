package com.ex.jsrab.async;

import android.os.AsyncTask;
import android.util.Log;

//import com.group2.bottomapp.HelperClass;

import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.entity.StringEntity;
import org.apache.http.impl.client.DefaultHttpClient;
import org.json.JSONObject;

import java.io.InputStream;

public class JsonRemoveIngredient extends AsyncTask<String, Void, String> {

    //Context context;

    public JsonRemoveIngredient(){
        //context = MainActivity.getAppContext();
    }

    @Override
    protected String doInBackground(String... urls) {
        return POSTIDENTIFIER(urls[0]);
    }
    @Override
    protected void onPostExecute(String result) {

    }

    public String POSTIDENTIFIER(String url){
        InputStream inputStream = null;
        String result = "";
        try {

            HttpClient httpclient = new DefaultHttpClient();
            HttpPost httpPost = new HttpPost(url);

            String json = "";

            JSONObject jsonObject = new JSONObject();
            //jsonObject.accumulate("id", HelperClass.User.userId);
            //jsonObject.accumulate("identifier", HelperClass.User.userIdentifier);

            json = jsonObject.toString();

            StringEntity se = new StringEntity(json);

            httpPost.setEntity(se);
            httpPost.setHeader("Accept", "application/json");
            httpPost.setHeader("Authorization", "apikey='1c9fk3u35ldcefgw'");
            httpPost.setHeader("Content-type", "application/json");

            HttpResponse httpResponse = httpclient.execute(httpPost);

            inputStream = httpResponse.getEntity().getContent();

            int statusCode = httpResponse.getStatusLine().getStatusCode();

            if(statusCode == 200){
                Log.d("com.group2", "Lyckades ta bort ingredient");
                //Toast.makeText(context, "Added " + "to cabinet", 1000).show();
                return "true";
            } else if(statusCode == 400 || statusCode == 401 || statusCode == 404 || statusCode == 500){
                //Log.d("com.group2", "Misslyckades med att ta bort ingredient, felkod: " + statusCode + " identifier: " + HelperClass.User.userIdentifier);
                //Toast.makeText(context, "Failed to add " + "to cabinet", 1000).show();
                return "false";
            }

            if(inputStream == null)
                result = "Did not work!";

        } catch (Exception e) {
            Log.d("InputStream", e.getLocalizedMessage());
            result = "Did not work!";
        }

        return result;
    }
}
