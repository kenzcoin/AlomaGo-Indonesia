# Endpoint Simple Documentation

### GET Top Kabar Burung
=> Limit 5 (default)

/public/kabar-burung?method=top&auth=:auth_key

=> Limit dari parameter

/public/kabar-burung?method=top&limit=:limit_num&auth=:auth_key

### GET List Kabar Burung
/public/kabar-burung?method=list&auth=:auth_key

### GET Detail Kabar Burung
/public/kabar-burung?method=detail&key=:kb_key&auth=:auth_key

### GET Search Kabar Burung
/public/kabar-burung?method=search&q=:query&auth=:auth_key

### GET User
/public/user?auth=:auth_key

### GET User Detail
/public/user?token=:token_user&auth=:auth_key

### GET Transaksi
#### Transfer Pulsa
/public/transaksi?method=transfer_pulsa&sort=[no_hp/user_id/detail:value]&auth=:auth_key

### GET download URL
/public/download?auth=:auth_key

### GET download URL detail
/public/download?auth=:auth_key&url=[1/2/3]

### POST Transaksi
=> auth

=> method (transfer_pulsa) Transfer pulsa
=> id_user
=> nomer_pengirim
=> nomer_tujuan
=> status (default: 0)
=> nominal

/public/transaksi