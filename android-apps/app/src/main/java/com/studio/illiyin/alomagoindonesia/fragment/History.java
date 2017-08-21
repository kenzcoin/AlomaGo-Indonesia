package com.studio.illiyin.alomagoindonesia.fragment;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;

import com.studio.illiyin.alomagoindonesia.Adapter.HistoryAdapter;
import com.studio.illiyin.alomagoindonesia.Adapter.model.HistoryModel;
import com.studio.illiyin.alomagoindonesia.R;

import java.util.ArrayList;

/**
 * Created by Mindha on 16/06/2017.
 */

public class History extends Fragment{
    View v;
    private static HistoryAdapter adapter;
    ArrayList<HistoryModel> dataModels;
    ListView listViewMessage;
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        v = inflater.inflate(R.layout.fragment_history, container, false);
        getActivity().setTitle("History");
        listViewMessage = (ListView) v.findViewById(R.id.listHistory);
        dummyHistory();
        initAdapter();
        return v;
    }

    public void dummyHistory(){
        dataModels = new ArrayList<>();
        for (int i=0;i<20;i++){
            String uri = "@drawable/icon_bird.png";
            dataModels.add(new HistoryModel(i, uri, "Number"+(i+1), "2017-02-02", "11:00","10.000"));
        }
    }


    public void initAdapter(){
        adapter = new HistoryAdapter(dataModels,getActivity().getApplicationContext());

        listViewMessage.setAdapter(adapter);
        listViewMessage.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                HistoryModel dataModel= dataModels.get(position);

            }
        });

    }
}
