package com.ex.jsrab;

import android.content.Context;
import android.util.Log;
import android.widget.Toast;

import java.text.DateFormatSymbols;

/**
 * Created by sam on 2/4/14.
 */
public class HelperFunctions {

    public static int allowedRetries = 20;

    public static class User{

        // This class stores all needed user data. Name, Email, Identifier and ID.

        public static String userName;
        public static String userEmail;
        public static String userIdentifier;
        public static int userId;
        //public static Context context = MainActivity




        // This will set all values on login
        public static void setValues(String result){

            try{

                // set userName
                int indexName = result.indexOf("|username:");
                userName = (result.substring(indexName, result.length()));
                userName = userName.replace("|username:", "");

                // set userIdentifier
                int indexIdentifier = result.indexOf("identifier");
                userIdentifier = (result.substring(indexIdentifier, result.length()));
                int delimiterIndex = userIdentifier.indexOf("|");
                userIdentifier = (userIdentifier.substring(0, delimiterIndex));
                userIdentifier = userIdentifier.replace("identifier:", "");

                // set userId
                String tempIdString = result.replace("Logged in successfully!|", "");
                int indexId = tempIdString.indexOf("|");
                tempIdString = (tempIdString.substring(0, indexId));
                tempIdString = tempIdString.replace("userId:", "");
                userId = Integer.parseInt(tempIdString);
            } catch(NumberFormatException nEx) {
                Log.e("BottomApp", "Exception: " + nEx.getMessage());
            } catch(IndexOutOfBoundsException iEx){
                Log.e("BottomApp", "Exception: " + iEx.getMessage());
            }
        }
    }
    public static String monthWithTwoInt(int mount){
        if(mount < 10){
            return "0"+mount;
        }else{
            return Integer.toString(mount);
        }
    }

    public static String getMonthForInt(int num) {
        String month = "wrong";
        DateFormatSymbols dfs = new DateFormatSymbols();
        String[] months = dfs.getMonths();
        if (num >= 0 && num <= 11 ) {
            month = months[num];
        }
        return month;
    }
    public static String dateToString(int year, int monthOfYear, int dayOfMonth){
        String dateString = "";

        dateString += year+"-";
        if(monthOfYear < 10){
            dateString += "0"+monthOfYear+"-";
        } else {
            dateString += monthOfYear+"-";
        }
        if(dayOfMonth < 10){
            dateString += "0"+dayOfMonth;
        } else {
            dateString += dayOfMonth;
        }

        return dateString;
    }
}
