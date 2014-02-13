package com.ex.jsrab.async;

import android.os.AsyncTask;
import android.util.Log;

import com.ex.jsrab.Createorder;
import com.ex.jsrab.LoginActivity;

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
public class Login extends AsyncTask<String, Void, String> {

    LoginActivity context;
    ArrayList<String> loginvalue;

    public Login(){
        //this.context = MainActivity;
    }
    public Login(LoginActivity context, ArrayList<String> loginvalue){
        this.context = context;
        this.loginvalue = loginvalue;

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

        } catch (Exception e) {
            Log.d("InputStream", e.getLocalizedMessage());
            result = "Did not work!";
        }

        return result;
    }
}
