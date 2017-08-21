package com.studio.illiyin.alomagoindonesia.MenuTab;

import android.os.Bundle;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ListView;

import java.util.ArrayList;
import com.studio.illiyin.alomagoindonesia.Adapter.KabarAdapter;
import com.studio.illiyin.alomagoindonesia.Adapter.model.KabarModel;
import com.studio.illiyin.alomagoindonesia.R;

public class Kabar extends Fragment {

    private static String endpointUri = String.valueOf(R.string.endpointUri);

    View v;
    private static KabarAdapter adapter;
    ArrayList<KabarModel> dataModels;
    ListView listViewMessage;

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        v = inflater.inflate(R.layout.fragment_berita_burung, container, false);
        listViewMessage = (ListView) v.findViewById(R.id.listBerita);
        dummyBerita();
        initAdapter();
//        new HttpAsyncTask().execute("http://hmkcode.appspot.com/rest/controller/get.json");
        return v;
    }

    public void content(){

    }

    public void dummyBerita(){
        dataModels = new ArrayList<>();
        for (int i=0;i<20;i++){
            String uri = "@drawable/icon_bird.png";
            dataModels.add(new KabarModel(i, uri, "Judul Berita "+(i+1), "2017-02-02"));
        }
    }


    public void initAdapter(){
        adapter = new KabarAdapter(dataModels,getActivity().getApplicationContext());

        listViewMessage.setAdapter(adapter);
        listViewMessage.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                KabarModel dataModel= dataModels.get(position);
            }
        });

    }
}
