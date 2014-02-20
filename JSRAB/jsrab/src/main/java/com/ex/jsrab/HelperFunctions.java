package com.ex.jsrab;

import android.content.Context;
import android.os.Vibrator;
import android.util.Log;
import android.widget.Toast;

import java.text.DateFormatSymbols;

/**
 * Created by sam on 2/4/14.
 */
public class HelperFunctions {

    public static int allowedRetries = 30;


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
        } else if (monthOfYear == 13) {
            dateString += 12+"-";
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

    public static void vibrate(Context context){
        Vibrator vibe = (Vibrator) context.getSystemService(Context.VIBRATOR_SERVICE) ;
        vibe.vibrate(50); // 50 is time in ms
    }
}
