package com.ex.jsrab;

/**
 * Created by sam on 2/6/14.
 */
public class Searchresult {
    public int id;
    public String date;
    public int customerID;
    public String customerName;
    public int tirethreadID;
    public String tirethreadName;
    public int tiresizeID;
    public String tiresizeName;
    public int total;
    public String comments;
    public String deliverydate;
    public int userID;
    public String lastChange;



    public String username;

    public Searchresult(){

    }

    public Searchresult(int id, String deliverydate, String customerName, String tirethreadName, String tiresizeName, String comments, int total, String username, String lastchange){
        this.id = id;
        this.deliverydate = deliverydate;
        this.customerName = customerName;
        this.tirethreadName = tirethreadName;
        this.tiresizeName = tiresizeName;
        this.comments = comments;
        this.total = total;
        this.username = username;
        this.lastChange = lastchange;
    }


    public String getUsername() {
        return username;
    }

    public void setUsername(String username) {
        this.username = username;
    }
    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public int getCustomerID() {
        return customerID;
    }

    public void setCustomerID(int customerID) {
        this.customerID = customerID;
    }

    public String getCustomerName() {
        return customerName;
    }

    public void setCustomerName(String customerName) {
        this.customerName = customerName;
    }

    public int getTirethreadID() {
        return tirethreadID;
    }

    public void setTirethreadID(int tirethreadID) {
        this.tirethreadID = tirethreadID;
    }

    public String getTirethreadName() {
        return tirethreadName;
    }

    public void setTirethreadName(String tirethreadName) {
        this.tirethreadName = tirethreadName;
    }

    public int getTiresizeID() {
        return tiresizeID;
    }

    public void setTiresizeID(int tiresizeID) {
        this.tiresizeID = tiresizeID;
    }

    public String getTiresizeName() {
        return tiresizeName;
    }

    public void setTiresizeName(String tiresizeName) {
        this.tiresizeName = tiresizeName;
    }

    public int getTotal() {
        return total;
    }

    public void setTotal(int total) {
        this.total = total;
    }

    public String getComments() {
        return comments;
    }

    public void setComments(String comments) {
        this.comments = comments;
    }

    public String getDeliverydate() {
        return deliverydate;
    }

    public void setDeliverydate(String deliverydate) {
        this.deliverydate = deliverydate;
    }

    public int getUserID() {
        return userID;
    }

    public void setUserID(int userID) {
        this.userID = userID;
    }

    public String getLastChange() {
        return lastChange;
    }

    public void setLastChange(String lastChange) {
        this.lastChange = lastChange;
    }
}
