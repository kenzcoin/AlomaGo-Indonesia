package com.studio.illiyin.alomagoindonesia.Adapter.model;

/**
 * Created by Mindha on 21/06/2017.
 */

public class HistoryModel {
    int id;
    String photo, number, day, time, price;

    public HistoryModel(int id, String photo, String number, String day, String time, String price) {
        this.id = id;
        this.photo = photo;
        this.number = number;
        this.day = day;
        this.time = time;
        this.price = price;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getPhoto() {
        return photo;
    }

    public void setPhoto(String photo) {
        this.photo = photo;
    }

    public String getNumber() {
        return number;
    }

    public void setNumber(String number) {
        this.number = number;
    }

    public String getDay() {
        return day;
    }

    public void setDay(String day) {
        this.day = day;
    }

    public String getTime() {
        return time;
    }

    public void setTime(String time) {
        this.time = time;
    }

    public String getPrice() {
        return price;
    }

    public void setPrice(String price) {
        this.price = price;
    }
}