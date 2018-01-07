package com.studio.illiyin.alomagoindonesia.fragment;

import android.app.ActionBar;
import android.app.WallpaperManager;
import android.content.res.Resources;
import android.graphics.drawable.Drawable;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.annotation.RequiresApi;
import android.support.design.widget.TabItem;
import android.support.design.widget.TabLayout;
import android.support.design.widget.TabLayout.Tab;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentActivity;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.app.FragmentTransaction;
import android.support.v4.view.ViewPager;
import android.support.v7.app.ActionBarActivity;
import android.support.v7.app.AppCompatActivity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toolbar;

import com.studio.illiyin.alomagoindonesia.MainActivityTab;
import com.studio.illiyin.alomagoindonesia.MenuTab.Kabar;
import com.studio.illiyin.alomagoindonesia.MenuTab.TransferPulsa;
import com.studio.illiyin.alomagoindonesia.R;

/**
 * Created by Mindha on 19/06/2017.
 */

public class Home extends Fragment implements ActionBar.TabListener {
    View v;

    private SectionsPagerAdapter mSectionsPagerAdapter;
    private ViewPager mViewPager;
    private ActionBar actionBar;
    private TabLayout TabLayout;
    private String[] tabs = { "Transfer Pulsa", "Berita Burung", "History"};

    @RequiresApi(api = Build.VERSION_CODES.LOLLIPOP)
    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container, Bundle savedInstanceState) {
        v = inflater.inflate(R.layout.fragment_satu, container, false);
       // getActivity().setTitle(R.string.app_name);
        ((AppCompatActivity)getActivity()).getSupportActionBar().setTitle(R.string.title_activity_main_tab);
        mSectionsPagerAdapter = new SectionsPagerAdapter(getChildFragmentManager());
        TabLayout = (TabLayout) v.findViewById(R.id.tabs);
        // Set up the ViewPager with the sections adapter.
        mViewPager = (ViewPager) v.findViewById(R.id.containers);
        mViewPager.setAdapter(mSectionsPagerAdapter);

        TabLayout tabLayout = (TabLayout) v.findViewById(R.id.tabs);
        tabLayout.setupWithViewPager(mViewPager);

        final int[] ICONS = new int[]{
                R.drawable.transfer,
                R.drawable.burung,
                R.drawable.history
        };

        for (int i=0; i< tabs.length ; i++) {
            TabLayout.getTabAt(i).setIcon(getResources().getDrawable(ICONS[i]));
        }

        return v;
    }

    @Override
    public void onTabSelected(ActionBar.Tab tab, android.app.FragmentTransaction ft) {

    }

    @Override
    public void onTabUnselected(ActionBar.Tab tab, android.app.FragmentTransaction ft) {

    }

    @Override
    public void onTabReselected(ActionBar.Tab tab, android.app.FragmentTransaction ft) {

    }

    public class SectionsPagerAdapter extends FragmentPagerAdapter {

        public SectionsPagerAdapter(FragmentManager fm) {
            super(fm);
        }

        @Override
        public Fragment getItem(int position) {
            switch (position) {
                case 0:
                    TransferPulsa tab1 = new TransferPulsa();
                    return tab1;
                case 1:
                    Kabar tab2 = new Kabar();
                    return tab2;
                case 2:
                    History tab3 = new History();
                    return tab3;
                default:
                    return null;
            }
        }

        @Override
        public int getCount() {
            // Show 3 total pages.
            return 3;
        }

        @Override
        public CharSequence getPageTitle(int position) {
//            switch (position) {
//                case 0:
//                    return "Transfer Pulsa";
//                case 1:
//                    return "Kabar Burung";
//                case 2:
//                    return "History";
//            }
            return null;
        }
    }
}
