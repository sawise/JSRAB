package com.ex.jsrab;

/**
 * Created by sam on 2/6/14.
 */
public class Tiresize {
    public int id;
    public String name;

    public Tiresize(){
    }

    public Tiresize(int id, String name){
        this.id = id;
        this.name = name;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }
}
