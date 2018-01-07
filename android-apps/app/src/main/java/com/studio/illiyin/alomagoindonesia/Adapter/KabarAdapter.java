package com.studio.illiyin.alomagoindonesia.Adapter;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;
import com.studio.illiyin.alomagoindonesia.Adapter.model.KabarModel;
import com.studio.illiyin.alomagoindonesia.R;

import java.util.ArrayList;

/**
 * Created by Mindha on 18/06/2017.
 */

public class KabarAdapter extends ArrayAdapter<KabarModel> {
    private int lastPosition = -1;
    private ArrayList<KabarModel> dataSet;
    Context mContext;
    private static class ViewHolder {
        ImageView photo_thumbnail;
        TextView itemJudul, txtTanggal;
        LinearLayout itemBerita;

    }
    KabarAdapter.ViewHolder viewHolder;
    public KabarAdapter(ArrayList<KabarModel> data, Context context) {
        super(context, R.layout.item_berita, data);
        this.dataSet = data;
        this.mContext=context;
    }

    @Override
    public View getView(int position, View convertView, ViewGroup parent) {
        KabarModel dataModel = getItem(position);
        final View result;
        if (convertView == null) {
            viewHolder = new KabarAdapter.ViewHolder();
            LayoutInflater inflater = LayoutInflater.from(mContext);
            convertView = inflater.inflate(R.layout.item_berita, parent, false);
            viewHolder.itemBerita= (LinearLayout) convertView.findViewById(R.id.itemBerita);
            viewHolder.photo_thumbnail = (ImageView) convertView.findViewById(R.id.imagenews);
            viewHolder.itemJudul= (TextView) convertView.findViewById(R.id.judul_berita);
            viewHolder.txtTanggal = (TextView) convertView.findViewById(R.id.tgl_berita);

            result=convertView;
            convertView.setTag(viewHolder);
        } else {
            viewHolder = (KabarAdapter.ViewHolder) convertView.getTag();
            result=convertView;
        }

        lastPosition = position;

        viewHolder.itemBerita.setVisibility(View.VISIBLE);
        Glide.with(mContext)
                .load(dataModel.getPhoto())
                .diskCacheStrategy(DiskCacheStrategy.RESULT)
                .skipMemoryCache(false)
                .into(viewHolder.photo_thumbnail);

        viewHolder.itemJudul.setText(dataModel.getJudul());
        viewHolder.txtTanggal.setText(dataModel.getDate());



        return convertView;
    }
}
