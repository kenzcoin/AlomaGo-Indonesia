package com.studio.illiyin.alomagoindonesia.MenuTab;

import android.graphics.Color;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.Spinner;

import com.studio.illiyin.alomagoindonesia.R;

/**
 * Created by Mindha on 16/06/2017.
 */

public class TransferPulsa extends Fragment{
    View myView;
    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, Bundle savedInstanceState) {
        myView = inflater.inflate(R.layout.fragment_transfer_pulsa,container,false);
        dropdownList(myView);

//        ImageView lineColorCode = (ImageView)myView.findViewById(R.id.icon_transfer);
        int color = Color.parseColor("#BDBDBD"); //The color u want
//        lineColorCode.setColorFilter(color);

        ImageView imageView = (ImageView) myView.findViewById(R.id.icon_transfer);
        imageView.setColorFilter(color);

        return myView;
    }

    public void dropdownList(View view){
        Spinner dynamicSpinner = (Spinner) view.findViewById(R.id.dynamic_spinner);

        String[] items = new String[] { "Pilihan 1", "Pilihan 2", "Pilihan 3" };

        ArrayAdapter<String> adapter = new ArrayAdapter<String>(getActivity(), android.R.layout.simple_spinner_item, items);

        dynamicSpinner.setAdapter(adapter);



        dynamicSpinner.setOnItemSelectedListener(new AdapterView.OnItemSelectedListener() {

            @Override
            public void onItemSelected(AdapterView<?> parent, View view, int position, long id) {
                Log.v("item", (String) parent.getItemAtPosition(position));
            }

            @Override
            public void onNothingSelected(AdapterView<?> parent) {
                // TODO Auto-generated method stub
            }
        });


    }




}
