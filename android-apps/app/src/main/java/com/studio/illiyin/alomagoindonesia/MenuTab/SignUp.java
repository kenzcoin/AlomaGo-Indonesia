package com.studio.illiyin.alomagoindonesia.MenuTab;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.v4.app.Fragment;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.studio.illiyin.alomagoindonesia.R;

/**
 * Created by Mindha on 21/06/2017.
 */

public class SignUp extends Fragment {
    View myView;
    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, Bundle savedInstanceState) {
        myView = inflater.inflate(R.layout.fragment_sign_up,container,false);
        return myView;
    }
}
