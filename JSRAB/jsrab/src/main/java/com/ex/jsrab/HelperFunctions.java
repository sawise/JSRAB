package com.ex.jsrab;

import java.text.DateFormatSymbols;

/**
 * Created by sam on 2/4/14.
 */
public class HelperFunctions {

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
