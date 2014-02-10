package com.ex.jsrab;

import android.app.Application;

/**
 * Created by sam on 2/10/14.
 */
public class Session {

    private static int orderID = 0;

    public static int getOrderID() {
        return orderID;
    }

    public static void setOrderID(int orderID) {
        Session.orderID = orderID;
    }
}
