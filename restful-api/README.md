# Endpoint Simple Documentation

### GET Top Kabar Burung
=> Limit 5
/public/kabar-burung?method=top&auth=:auth_key
=> Limit dari parameter
/public/kabar-burung?method=top&limit=:limit_num&auth=:auth_key

### GET List Kabar Burung
/public/kabar-burung?method=list&auth=:auth_key

### GET Detail Kabar Burung
/public/kabar-burung?method=detail&key=:kb_key&auth=:auth_key