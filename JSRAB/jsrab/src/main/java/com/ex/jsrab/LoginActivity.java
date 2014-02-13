package com.ex.jsrab;

/**
 * Created by sam on 2/13/14.
 */
import android.app.Activity;
        import android.animation.Animator;
        import android.animation.AnimatorListenerAdapter;
        import android.annotation.TargetApi;
        import android.content.Context;
        import android.database.*;
        import android.content.Intent;
        import android.net.ConnectivityManager;
        import android.os.AsyncTask;
        import android.os.Build;
        import android.os.Bundle;
        import android.text.TextUtils;
        import android.util.Log;
        import android.view.KeyEvent;
        import android.view.Menu;
        import android.view.View;
        import android.view.inputmethod.EditorInfo;
        import android.widget.EditText;
        import android.widget.TextView;
        import android.widget.Toast;

import org.apache.http.HttpEntity;
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
import org.apache.http.util.EntityUtils;

import java.io.BufferedReader;
        import java.io.FileNotFoundException;
        import java.io.IOException;
        import java.io.InputStream;
        import java.io.InputStreamReader;
        import java.io.OutputStreamWriter;
        import java.io.UnsupportedEncodingException;
        import java.net.URL;
        import java.security.MessageDigest;
        import java.security.NoSuchAlgorithmException;
import java.util.ArrayList;
import java.util.List;

public class LoginActivity extends Activity {
    /**
     * The default username to populate the username field with.
     */
    public static final String EXTRA_TEXT = "se.softwerk.coffee.TEXT";

    /**
     * Keep track of the login task to ensure we can cancel it if requested.
     */
    private UserLoginTask mAuthTask = null;

    // Values for username and password at the time of the login attempt.
    private String mUsername;
    private String mPassword;





    // UI references.
    private EditText mUsernameView;
    private EditText mPasswordView;
    private View mLoginFormView;
    private View mLoginStatusView;
    private TextView mLoginStatusMessageView;


    // Salt
    private String salt = "34A75DD4C4DF5E4DDFC68CA975B35";




    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);


        // Set up the login form.
        //mUsername = getIntent().getStringExtra(EXTRA_TEXT);
        mUsernameView = (EditText) findViewById(R.id.username);
        mUsernameView.setText(mUsername);

        mPasswordView = (EditText) findViewById(R.id.password);
        mPasswordView.setOnEditorActionListener(new TextView.OnEditorActionListener() {
            @Override
            public boolean onEditorAction(TextView textView, int id, KeyEvent keyEvent) {
                if (id == R.id.login || id == EditorInfo.IME_NULL) {
                    attemptLogin();
                    return true;
                }
                return false;
            }
        });

        mLoginFormView = findViewById(R.id.login_form);
        mLoginStatusView = findViewById(R.id.login_status);
        mLoginStatusMessageView = (TextView) findViewById(R.id.login_status_message);

        findViewById(R.id.sign_in_button).setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                attemptLogin();
            }
        });
        Log.i("LoginActivity", "Version: " +  android.os.Build.VERSION.SDK_INT);
        String rememberMe = getSharedPreferences(Session.getPrefsuser(), MODE_PRIVATE).getString("username", null);
        if(rememberMe != null){
            int id = getSharedPreferences(Session.getPrefsuser(), MODE_PRIVATE).getInt("id", 0);
            Log.i("login id", ""+id);
            Session.setUserID(id);
            Intent i = new Intent(getApplicationContext(), MainActivity.class);
            startActivity(i);
            finish();
            Toast.makeText(this, "Login lyckades!", Toast.LENGTH_LONG).show();
        }

    }



    /**
     * Reads file containing hashed credentials and converts content to string array.
     */


    /**
     * Hash functions used to hash username and password.
     */
    private static String convertToHex(byte[] data) {
        StringBuilder buf = new StringBuilder();
        for (byte b : data) {
            int halfbyte = (b >>> 4) & 0x0F;
            int two_halfs = 0;
            do {
                buf.append((0 <= halfbyte) && (halfbyte <= 9) ? (char) ('0' + halfbyte) : (char) ('a' + (halfbyte - 10)));
                halfbyte = b & 0x0F;
            } while (two_halfs++ < 1);
        }
        return buf.toString();
    }

    private static String SHA256(String text) throws NoSuchAlgorithmException, UnsupportedEncodingException {
        MessageDigest md = MessageDigest.getInstance("SHA-256");
        md.update(text.getBytes("UTF-8"), 0, text.length());
        byte[] sha256hash = md.digest();
        return convertToHex(sha256hash);
    }

    /**
     * Attempts to sign in the account specified by the login form.
     * If there are form errors (missing fields, etc.), the
     * errors are presented and no actual login attempt is made.
     */
    public void attemptLogin() {

        if (mAuthTask != null) {
            return;
        }
        // Reset errors.
        mUsernameView.setError(null);
        mPasswordView.setError(null);

        // Store values at the time of the login attempt.
        mUsername = mUsernameView.getText().toString();
        mPassword = mPasswordView.getText().toString();

        boolean cancel = false;
        View focusView = null;

        // Check for a valid password.
        if (TextUtils.isEmpty(mPassword)) {
            mPasswordView.setError("Du måste skriva in lösenord");
            focusView = mPasswordView;
            cancel = true;
        }

        // Check for a valid username.
        if (TextUtils.isEmpty(mUsername)) {
            mUsernameView.setError("Du måste skriva in användarnamn!");
            focusView = mUsernameView;
            cancel = true;
        }

        if (cancel) {
            // There was an error; don't attempt login and focus the first
            // form field with an error.
            focusView.requestFocus();
        } else {
            // Show a progress spinner, and kick off a background task to
            // perform the user login attempt.
            mLoginStatusMessageView.setText("Loggar in....");
            showProgress(true);
            mAuthTask = new UserLoginTask();
            mAuthTask.execute((Void) null);
        }
    }

    /**
     * Shows the progress UI and hides the login form.
     */
    @TargetApi(Build.VERSION_CODES.HONEYCOMB_MR2)
    private void showProgress(final boolean show) {
        // On Honeycomb MR2 we have the ViewPropertyAnimator APIs, which allow
        // for very easy animations. If available, use these APIs to fade-in
        // the progress spinner.
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.HONEYCOMB_MR2) {
            int shortAnimTime = getResources().getInteger(android.R.integer.config_shortAnimTime);

            mLoginStatusView.setVisibility(View.VISIBLE);
            mLoginStatusView.animate()
                    .setDuration(shortAnimTime)
                    .alpha(show ? 1 : 0)
                    .setListener(new AnimatorListenerAdapter() {
                        @Override
                        public void onAnimationEnd(Animator animation) {
                            mLoginStatusView.setVisibility(show ? View.VISIBLE : View.GONE);
                        }
                    });

            mLoginFormView.setVisibility(View.VISIBLE);
            mLoginFormView.animate()
                    .setDuration(shortAnimTime)
                    .alpha(show ? 0 : 1)
                    .setListener(new AnimatorListenerAdapter() {
                        @Override
                        public void onAnimationEnd(Animator animation) {
                            mLoginFormView.setVisibility(show ? View.GONE : View.VISIBLE);
                        }
                    });
        } else {
            // The ViewPropertyAnimator APIs are not available, so simply show
            // and hide the relevant UI components.
            mLoginStatusView.setVisibility(show ? View.VISIBLE : View.GONE);
            mLoginFormView.setVisibility(show ? View.GONE : View.VISIBLE);
        }
    }

    /**
     * Represents an asynchronous login/registration task used to authenticate
     * the user.
     */
    public class UserLoginTask extends AsyncTask<Void, Void, Boolean> {
        @Override
        protected Boolean doInBackground(Void... params) {
            // TODO: attempt authentication against a network service.

/*            try {
                // Simulate network access.
                Thread.sleep(2000);
            } catch (InterruptedException e) {
                return false;
            }
*/

            // Check if credentials match.
            try {
                HttpParams httpParams = new BasicHttpParams();

                int timeoutConnection = 3000;
                int timeoutSocket = 5000;
                HttpConnectionParams.setConnectionTimeout(httpParams, timeoutConnection);
                HttpConnectionParams.setSoTimeout(httpParams, timeoutSocket);

                HttpClient httpclient = new DefaultHttpClient(httpParams);
                HttpPost httppost = new HttpPost(APIManager.URL+"/loginapp.php");

                List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(2);
                nameValuePairs.add(new BasicNameValuePair("user",mUsername));
                nameValuePairs.add(new BasicNameValuePair("pass", SHA256(mPassword + salt)));

                httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));

                HttpResponse response = httpclient.execute(httppost);
                HttpEntity httpEntity = response.getEntity();
                String success = EntityUtils.toString(httpEntity);
                Log.i("login test", success);
                if (success.contains("true")) {
                    String[] pieces = success.split(":");
                    Session.setUserID(Integer.parseInt(pieces[1]));
                    User u = new User(Session.getUserID(), mUsername, SHA256(mPassword + salt));
                    getSharedPreferences(Session.getPrefsuser(), MODE_PRIVATE).edit().putString("username", u.getUsername()).commit();
                    getSharedPreferences(Session.getPrefsuser(), MODE_PRIVATE).edit().putString("password", u.getUsername()).commit();
                    getSharedPreferences(Session.getPrefsuser(), MODE_PRIVATE).edit().putInt("id", u.getId()).commit();

                    // Account exists, return true
                    return true;
                } else {
                    return false;
                }
            } catch (Exception e) {
                Log.i("login ex", ""+e);
            }
            return false;
        }

        @Override
        protected void onPostExecute(final Boolean success) {
            mAuthTask = null;
            showProgress(false);

            if (success) {
                // Go to MainActivity.
                Intent i = new Intent(getApplicationContext(), MainActivity.class);
                startActivity(i);
                showProgress(true);
                Toast.makeText(getApplicationContext(), "Login successful!", Toast.LENGTH_SHORT).show();
                // Kill LoginActivity.
                finish();
            } else {
                mPasswordView.setError("Fel lösenord");
                mPasswordView.requestFocus();
            }
        }

        @Override
        protected void onCancelled() {
            mAuthTask = null;
            showProgress(false);
        }
    }
}

