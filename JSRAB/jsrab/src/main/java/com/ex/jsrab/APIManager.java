package com.ex.jsrab;


import android.content.Context;
import android.util.Log;

import com.ex.jsrab.Search;
import com.ex.jsrab.Searchresult;
import com.ex.jsrab.async.CreateOrder;
import com.ex.jsrab.async.DeleteOrder;
import com.ex.jsrab.async.EditOrder;
import com.ex.jsrab.async.JsonCustomer;
import com.ex.jsrab.async.JsonSearch;
import com.ex.jsrab.async.JsonTiresize;
import com.ex.jsrab.async.JsonTirethread;
import com.ex.jsrab.async.JsonWeeklyOrder;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.Calendar;

public class APIManager {

    public static ArrayList<Searchresult> searchresults = new ArrayList<Searchresult>();
    public static ArrayList<Searchresult> weeklyorders = new ArrayList<Searchresult>();
    public static ArrayList<Tiresize> tiresizes = new ArrayList<Tiresize>();
    public static ArrayList<Tirethread> tirethreads = new ArrayList<Tirethread>();
    public static ArrayList<Customer> customers = new ArrayList<Customer>();
    public static String URL = "http://jsretreading.se/admin";

    public static void updateEverything() {
        try {
            Calendar c = Calendar.getInstance();
            //updateSearch("");
            updateTiresize();
            updateTirethread();
            updateWeeklyOrders(c.get(Calendar.YEAR),c.get(Calendar.WEEK_OF_YEAR));
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static ArrayList<Customer> getCustomers() {
        //if(!hazInternetz()) return new ArrayList<Cocktail>();
        try {
            updateCustomer();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return customers;
    }

    public static void updateCustomer() throws IOException, JSONException {
        JsonCustomer task = new JsonCustomer();
        task.execute(URL+"/post_customer-json.php");
    }



    public static ArrayList<Customer> getCustomerfromJSON(String json) {
        try {
            JSONObject searchObject = new JSONObject(json);
            JSONArray searchArray = searchObject.getJSONArray("rows");
            Log.i("JSON arr", searchArray.toString());
            ArrayList<Customer> listToReturn = new ArrayList<Customer>();
            for (int i = 0; i < searchArray.length(); i++) {
                JSONObject searchObj = searchArray.getJSONObject(i);
                JSONObject searchObjinObj = searchObj.getJSONObject("cell");
                Log.i("JSON objinobj", searchObjinObj+"");
                int id = searchObjinObj.getInt("id");
                String name = searchObjinObj.getString("name");
                listToReturn.add(new Customer(id, name));
            }
            return listToReturn;

        } catch (Exception e) {
            Log.i("post fail", ""+e);
        }
        return null;
    }

    public static ArrayList<Tiresize> getTiresizes() {
        //if(!hazInternetz()) return new ArrayList<Cocktail>();
        try {
            updateTiresize();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return tiresizes;
    }

    public static void updateTiresize() throws IOException, JSONException {
        JsonTiresize task = new JsonTiresize();
        task.execute(URL+"/post_tiresize-json.php");
    }



    public static ArrayList<Tiresize> getTiresizefromJSON(String json) {
        try {
            JSONObject searchObject = new JSONObject(json);
            JSONArray searchArray = searchObject.getJSONArray("rows");
            Log.i("JSON arr", searchArray.toString());
            ArrayList<Tiresize> listToReturn = new ArrayList<Tiresize>();
                for (int i = 0; i < searchArray.length(); i++) {
                    JSONObject searchObj = searchArray.getJSONObject(i);
                    JSONObject searchObjinObj = searchObj.getJSONObject("cell");
                    Log.i("JSON objinobj", searchObjinObj+"");
                    int id = searchObjinObj.getInt("id");
                    String name = searchObjinObj.getString("name");
                    listToReturn.add(new Tiresize(id, name));
                }
            return listToReturn;

        } catch (Exception e) {
            Log.i("post fail", ""+e);
        }
        return null;
    }

    public static ArrayList<Tirethread> getTirethreads() {
        //if(!hazInternetz()) return new ArrayList<Cocktail>();
        try {
            updateTirethread();
        } catch (Exception e) {
            e.printStackTrace();
        }
        return tirethreads;
    }

    public static void updateTirethread() throws IOException, JSONException {
        JsonTirethread task = new JsonTirethread();
        task.execute(URL+"/post_tirethread-json.php");
    }

    public static ArrayList<Tirethread> getTirethreadfromJSON(String json) {
        try {
            JSONObject searchObject = new JSONObject(json);
            JSONArray searchArray = searchObject.getJSONArray("rows");
            Log.i("JSON arr", searchArray.toString());
            ArrayList<Tirethread> listToReturn = new ArrayList<Tirethread>();
            for (int i = 0; i < searchArray.length(); i++) {
                JSONObject searchObj = searchArray.getJSONObject(i);
                JSONObject searchObjinObj = searchObj.getJSONObject("cell");
                Log.i("JSON objinobj", searchObjinObj+"");
                int id = searchObjinObj.getInt("id");
                String name = searchObjinObj.getString("name");
                listToReturn.add(new Tirethread(id, name));
            }
            return listToReturn;

        } catch (Exception e) {
            Log.i("post fail", ""+e);
        }
        return null;
    }

    public static void updateSearch(String searchString, String tireThread, String tireSize, String dateStart, String dateEnd) throws IOException, JSONException {
        JsonSearch task = new JsonSearch();
        task.execute(URL+"/post-json.php?search="+searchString+"&tirethread="+tireThread+"&tiresize="+tireSize+"&datestart="+dateStart+"&dateend="+dateEnd+"&mobile=yes");
    }

    public static ArrayList<Searchresult> getSearchresults(String searchString, String tireThread, String tireSize, String dateStart, String dateEnd) {
        //if(!hazInternetz()) return new ArrayList<Cocktail>();
        try {
            updateSearch(searchString, tireThread, tireSize, dateStart, dateEnd);
        } catch (Exception e) {
            e.printStackTrace();
        }
        return searchresults;
    }

    public static ArrayList<Searchresult> getSearchresultfromJSON(String json) {
        try {
            JSONObject searchObject = new JSONObject(json);
            Log.i("JSON obj", searchObject+"-"+searchObject.toString());
            JSONArray searchArray = searchObject.getJSONArray("rows");
            Log.i("JSON arr", searchArray.toString());
            ArrayList<Searchresult> listToReturn = new ArrayList<Searchresult>();

            if(searchArray.length() == 0){
                //listToReturn.add(new Searchresult(0, "N/A", "N/A", "N/A", "N/A","N/A", 0));
            } else {
                for (int i = 0; i < searchArray.length(); i++) {
                    JSONObject searchObj = searchArray.getJSONObject(i);
                    JSONObject searchObjinObj = searchObj.getJSONObject("cell");
                    Log.i("JSON objinobj", searchObjinObj+"");
                    int id = searchObjinObj.getInt("id");
                    String date = searchObjinObj.getString("deliverydate");
                    //int customerID = searchObj.getInt("customerID");
                    String customerName = searchObjinObj.getString("customer_name");
                    String tirethreadName = searchObjinObj.getString("tiretread_name");
                    String tiresizeName = searchObjinObj.getString("tiresize_name");
                    String comments = searchObjinObj.getString("comments");
                    String username = searchObjinObj.getString("username");
                    int total = searchObjinObj.getInt("total");
                    String lastchange = searchObjinObj.getString("lastchange");
                    listToReturn.add(new Searchresult(id, date, customerName, tirethreadName, tiresizeName,comments, total, username, lastchange));
                }
            }


            return listToReturn;

        } catch (Exception e) {
            Log.i("post fail", ""+e);
        }
        return null;
    }

    public static void updateWeeklyOrders(int year, int week) throws IOException, JSONException {
        JsonWeeklyOrder task = new JsonWeeklyOrder();
        task.execute(URL+"/post_year-json.php?year="+year+"&week="+week+"&mobile=yes");
    }

    public static ArrayList<Searchresult> getWeeklyOrders(int year, int week) {
        //if(!hazInternetz()) return new ArrayList<Cocktail>();
        try {
            updateWeeklyOrders(year, week);
        } catch (Exception e) {
            e.printStackTrace();
        }
        return weeklyorders;
    }

    public static ArrayList<Searchresult> getWeeklyOrderfromJSON(String json) {
        try {
            JSONObject searchObject = new JSONObject(json);
            Log.i("JSON obj", searchObject+"-"+searchObject.toString());
            JSONArray searchArray = searchObject.getJSONArray("rows");
            Log.i("JSON arr", searchArray.toString());
            //JSONArray searchRows = new JSONArray(searchArray.getJSONArray());
            ArrayList<Searchresult> listToReturn = new ArrayList<Searchresult>();
            Log.i("JSON count", ""+searchArray.length());

            if(searchArray.length() == 0){
                //listToReturn.add(new Searchresult(0, "N/A", "N/A", "N/A", "N/A","N/A", 0));
            } else {
                for (int i = 0; i < searchArray.length(); i++) {
                    JSONObject searchObj = searchArray.getJSONObject(i);
                    JSONObject searchObjinObj = searchObj.getJSONObject("cell");
                    Log.i("JSON objinobj", searchObjinObj+"");
                    int id = searchObjinObj.getInt("id");
                    String date = searchObjinObj.getString("deliverydate");
                    //int customerID = searchObj.getInt("customerID");
                    String customerName = searchObjinObj.getString("customer_name");
                    String tirethreadName = searchObjinObj.getString("tiretread_name");
                    String tiresizeName = searchObjinObj.getString("tiresize_name");
                    String username = searchObjinObj.getString("username");
                    String comments = searchObjinObj.getString("comments");
                    String lastchange = searchObjinObj.getString("lastchange");
                    int total = searchObjinObj.getInt("total");
                    listToReturn.add(new Searchresult(id, date, customerName, tirethreadName, tiresizeName,comments, total, username, lastchange));
                }
            }

            return listToReturn;

        } catch (Exception e) {
            Log.i("post fail", ""+e);
        }
        return null;
    }

    public static void createOrder(Context context, ArrayList<String> ordervalue) {
        CreateOrder createOrder = new CreateOrder(context, ordervalue);
        createOrder.execute(URL+"/createOrder.php");
    }
    public static void editOrder(Context context, ArrayList<String> ordervalue) {
        EditOrder editOrder = new EditOrder(context, ordervalue);
        editOrder.execute(URL+"/updateOrder.php");
    }
    public static void deleteOrder(Context context, ArrayList<String> ordervalue) {
        DeleteOrder deleteOrder= new DeleteOrder(context, ordervalue);
        deleteOrder.execute(URL+"/deleteorder.php");
    }



  /*





    //Uploads
    public static void addIngredientToAccount(int ingId) {
        Log.d("tjafsmannen", "försöker lägga till " + ingId + " till konto");
        JsonAddIngredient jsonAddIngredient = new JsonAddIngredient();
        jsonAddIngredient.execute("http://dev2-vyh.softwerk.se:8080/bottomAppServer/json/users/add/ingredient/" + ingId);
    }


    public static void removeFavoriteToAccount(int ingId) {
        CreateOrder jsonAddFavorite = new CreateOrder();
        jsonAddFavorite.execute("http://dev2-vyh.softwerk.se:8080/bottomAppServer/json/users/remove/favorite/drink/" + ingId);
    }

    public static void removeIngredientfromAccount(int ingId) {
        Log.d("tjafsmannen", "försöker lägga till " + ingId + " till konto");
        JsonRemoveIngredient jsonRemoveIngredient = new JsonRemoveIngredient();
        jsonRemoveIngredient.execute("http://dev2-vyh.softwerk.se:8080/bottomAppServer/json/users/remove/ingredient/" + ingId);
    }

    private static boolean hazInternetz() {
        ConnectivityManager connMgr = (ConnectivityManager) MainActivity.getAppContext().getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo networkInfo = connMgr.getActiveNetworkInfo();

        if (networkInfo != null && networkInfo.isConnected()) {
            return true;
        }
        return false;
    }*/
}
