package com.ex.jsrab;


import android.content.Context;
import android.util.Log;

import com.ex.jsrab.Search;
import com.ex.jsrab.Searchresult;
import com.ex.jsrab.async.CreateOrder;
import com.ex.jsrab.async.JsonSearch;
import com.ex.jsrab.async.JsonWeeklyOrder;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;

public class APIManager {

    public static ArrayList<Searchresult> searchresults = new ArrayList<Searchresult>();
    public static ArrayList<Searchresult> weeklyorders = new ArrayList<Searchresult>();


    public static void updateEverything() {
        try {
            updateSearch("");
        } catch (Exception e) {
            e.printStackTrace();
        }
    }

    public static void updateSearch(String searchString) throws IOException, JSONException {
        JsonSearch task = new JsonSearch();
        task.execute("http://192.168.43.138/post-json.php?search="+searchString+"&tirethread=nothread&tiresize=nosize&datestart=nodate&dateend=&mobile=yes");
    }

    public static ArrayList<Searchresult> getSearchresults(String searchString) {
        //if(!hazInternetz()) return new ArrayList<Cocktail>();
        try {
            updateSearch(searchString);
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
                listToReturn.add(new Searchresult(0, "N/A", "N/A", "N/A", "N/A","N/A", 0));
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
                    int total = searchObjinObj.getInt("total");
                    listToReturn.add(new Searchresult(id, date, customerName, tirethreadName, tiresizeName,comments, total));
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
        task.execute("http://192.168.43.138/post_year-json.php?year="+year+"&week="+week);
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
                listToReturn.add(new Searchresult(0, "N/A", "N/A", "N/A", "N/A","N/A", 0));
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
                    int total = searchObjinObj.getInt("total");
                    listToReturn.add(new Searchresult(id, date, customerName, tirethreadName, tiresizeName,comments, total));

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
        createOrder.execute("http://192.168.43.138/createOrder.php");
    }



    /*


    public static void updateCategories() throws IOException, JSONException {
        JsonDownloadCategories task = new JsonDownloadCategories();
        task.execute("http://dev2-vyh.softwerk.se:8080/bottomAppServer/json/categories/all");
    }

    public static void updateIngredients() throws IOException, JSONException {
        JsonDownloadIngredients task = new JsonDownloadIngredients();
        task.execute("http://dev2-vyh.softwerk.se:8080/bottomAppServer/json/ingredients/all");
    }

    public static void updateIngredientsUser(int userID) throws IOException, JSONException {
        JsonDownloadIngredientsByUser task = new JsonDownloadIngredientsByUser();
        task.execute("http://dev2-vyh.softwerk.se:8080/bottomAppServer/json/users/"+userID+"/ingredients");
    }
    public static void updateCocktailByFavorite(int userID) throws IOException, JSONException {
        JsonDownloadFavoriteDrinksByUser task = new JsonDownloadFavoriteDrinksByUser();
        task.execute("http://dev2-vyh.softwerk.se:8080/bottomAppServer/json/users/"+userID+"/favorite/drink");
    }





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
