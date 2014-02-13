package com.ex.jsrab;

import android.app.Application;

import java.util.Calendar;

/**
 * Created by sam on 2/10/14.
 */
public class Session {

    private static int userID = 0;

    public static int getUserID() {
        return userID;
    }

    public static void setUserID(int userID) {
        Session.userID = userID;
    }

    private static int orderID = 0;
    private static int year = 0;
    private static int week = 0;
    private static int month = 0;
    private int spinner1Pos, spinner2Pos;
    private Calendar startDate;
    private Calendar endDate;
    public static final String PREFSUSER = "PREFUSER";

    public static String getUserIdStr() {
        return Integer.toString(userID);
    }

    public static String getPrefsuser() {
        return PREFSUSER;
    }

    public int getSpinner1Pos() {
        return spinner1Pos;
    }

    public void setSpinner1Pos(int spinner1Pos) {
        this.spinner1Pos = spinner1Pos;
    }

    public int getSpinner2Pos() {
        return spinner2Pos;
    }

    public void setSpinner2Pos(int spinner2Pos) {
        this.spinner2Pos = spinner2Pos;
    }

    public Calendar getStartDate() {
        return startDate;
    }

    public void setStartDate(Calendar startDate) {
        this.startDate = startDate;
    }

    public Calendar getEndDate() {
        return endDate;
    }

    public void setEndDate(Calendar endDate) {
        this.endDate = endDate;
    }

    public static int getMonth() {
        return month;
    }

    public static void setMonth(int month) {
        Session.month = month;
    }

    public static int getYear() {
        return year;
    }

    public static void setYear(int year) {
        Session.year = year;
    }

    public static int getWeek() {
        return week;
    }

    public static void setWeek(int week) {
        Session.week = week;
    }

    public static int getOrderID() {
        return orderID;
    }

    public static void setOrderID(int orderID) {
        Session.orderID = orderID;
    }
}
