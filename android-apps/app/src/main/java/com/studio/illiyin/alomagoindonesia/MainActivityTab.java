package com.studio.illiyin.alomagoindonesia;

import android.support.v4.app.FragmentTransaction;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;

import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentPagerAdapter;
import android.support.v4.view.ViewPager;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Toast;

import com.studio.illiyin.alomagoindonesia.fragment.About;
import com.studio.illiyin.alomagoindonesia.fragment.Disclaimer;
import com.studio.illiyin.alomagoindonesia.fragment.Feedback;
import com.studio.illiyin.alomagoindonesia.fragment.Registration;
import com.studio.illiyin.alomagoindonesia.fragment.Home;
import com.studio.illiyin.alomagoindonesia.fragment.History;
import com.studio.illiyin.alomagoindonesia.fragment.PrivacyPolicy;
import com.studio.illiyin.alomagoindonesia.fragment.Rate;
import com.studio.illiyin.alomagoindonesia.fragment.TellFriend;

public class MainActivityTab extends AppCompatActivity {

    /**
     * The {@link android.support.v4.view.PagerAdapter} that will provide
     * fragments for each of the sections. We use a
     * {@link FragmentPagerAdapter} derivative, which will keep every
     * loaded fragment in memory. If this becomes too memory intensive, it
     * may be best to switch to a
     * {@link android.support.v4.app.FragmentStatePagerAdapter}.
     */

    /**
     * The {@link ViewPager} that will host the section contents.
     */


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main_tab);

        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

//        getActionBar().setHomeButtonEnabled(false);
//        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
//        getSupportActionBar().setTitle("Main Activity");
//        getActionBar().setDisplayHomeAsUpEnabled(fal);
//        getActionBar().setHomeButtonEnabled(true);

        // Create the adapter that will return a fragment for each of the three
        // primary sections of the activity.
        Fragment first = new Home();
        FragmentTransaction fragment = getSupportFragmentManager().beginTransaction();
        fragment.replace(R.id.container, first);
        fragment.commit();

        //Toast.makeText(getApplicationContext(), ((MainActivityTab) getApplicationContext()).getViewPager().getCurrentItem() ,Toast.LENGTH_SHORT).show();
        // getActivity()).getViewPager().getCurrentItem()
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main_activity_tab, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();

        if (id==android.R.id.home) {
            Fragment tab1 = new Home();
            getSupportActionBar().setDisplayHomeAsUpEnabled(false);
            changeFragment(tab1);
            return true;
        }

        if (id == R.id.sign_in){
            Fragment tab1 = new Registration();
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            setActionBarTitle("Signin/Registration");
            changeFragment(tab1);
            return true;
        }else if (id == R.id.history){
             Fragment tab1 = new History();
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            setActionBarTitle("History");
            changeFragment(tab1);
            return true;
        }else if (id == R.id.rate){
            Fragment tab1 = new Rate();
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            setActionBarTitle("Rate App");
            changeFragment(tab1);
            return true;
        }else if (id == R.id.tell_friend){
            Fragment tab1 = new TellFriend();
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            setActionBarTitle("Tell a friend");
            changeFragment(tab1);
            return true;
        }else if (id == R.id.feedback){
            Fragment tab1 = new Feedback();
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            setActionBarTitle("Feedback");
            changeFragment(tab1);
            return true;
        }else if (id == R.id.disclaimer){
            Fragment tab1 = new Disclaimer();
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            setActionBarTitle("Disclaimer");
            changeFragment(tab1);
            return true;
        }else if (id == R.id.privacy){
            Fragment tab1 = new PrivacyPolicy();
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            setActionBarTitle("Privacy Policy");
            changeFragment(tab1);
            return true;
        }else if (id == R.id.about){
            Fragment tab1 = new About();
            getSupportActionBar().setDisplayHomeAsUpEnabled(true);
            setActionBarTitle("About");
            changeFragment(tab1);
            return true;
        }


        return super.onOptionsItemSelected(item);
    }

    public void changeFragment(Fragment fragments){
        FragmentTransaction fragment = getSupportFragmentManager().beginTransaction();
        fragment.replace(R.id.container, fragments);
        fragment.commitNow();
    }

    public void setActionBarTitle(String title) {
        getSupportActionBar().setTitle(title);
    }

}
