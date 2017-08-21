package com.studio.illiyin.alomagoindonesia.Adapter.model;

/**
 * Created by Mindha on 18/06/2017.
 */

public class KabarModel {
    int id;
    String photo, judul, date;

    public KabarModel(int id, String photo, String judul, String date) {
        this.id = id;
        this.photo = photo;
        this.judul = judul;
        this.date = date;
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

    public String getJudul() {
        return judul;
    }

    public void setJudul(String judul) {
        this.judul = judul;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }
}
