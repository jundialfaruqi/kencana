https://api.fsetiawan.my.id/api/login

yg diisi di body form-data :
email :
password :

##respon json status 200 untuk user role = admin
{
"success": true,
"message": "Login berhasil.",
"data": {
"user": {
"name": "admin",
"email": "admin@fsetiawan.my.id",
"role": "admin"
},
"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIwMTljMDNlNi0zZGY2LTcyYTQtOWQ2Zi01MGQxZjFjYWQyNGMiLCJqdGkiOiI1MTZkM2Y3YmZlMDJmOTU4MWEzZTNiZDNhM2RkOTE1MGU1MDZjYTA4M2Y5NTYzNDhmMzFiNzkxNzZjZWNlODA4Y2Y2ZTkwMGU1M2VmY2E0ZiIsImlhdCI6MTc2OTY1MDAxNy44MTU0MDksIm5iZiI6MTc2OTY1MDAxNy44MTU0MTIsImV4cCI6MTgwMTE4NjAxNy44MDgyMjEsInN1YiI6IjIiLCJzY29wZXMiOltdfQ.PszcZ6_RicixReCUzlBP2IZRNr2SutwP_6bpfiBjI0O6r-7ZWmMYrQLPBVDjFG2DKzphv5TBCyFnjxCajx-Gk4op7qp3VsB-\_MDA_kW9s9j7owuGNCF-5vDHWnt9pHXWAuLRV_biUvPdrpXsl82juUuhN9S7vz7ve9fFFp-5VNekr0mVs3ratdUoFFTFEepjB5ca0XLa_E5LvnrZQ9cCk4qSBsYJPkjJtzYxrQywO0lf8i3yoaz-onlH1TrFxbFPfk8h-AVZ_L3-4nvLbZdQt7r_1EMiwfAFo5-cstU1jHhb3eh6FsORR9sp9AXlA-KafJF_AYwMCVztJcLjF1RR8IFAv8EDemAou6cvkX_Sqj1QMMaj_xCUDoGxpvLw_AvUkC9eg9DFkAkud6rRFITHXGxM84Acfr1V99dyIjwtE8NvqNUO_W0B0AHogUSZWygjsVVCBQoqC4w7WxXpCCsbiXal2mx7hZDXbvPyWmxkB-25VkLNIZVrbaJrBs652857LbkAhGLB-ku9gWTpILfulMVUJ_Pp8VPfwBAcuU1KGog_KP18Jh7MWKupVWsUJbDZ\_\_L1m6erI6Xfaxph8PdpeRnLU9OEXqP738tk8xS9qnNe_dc-BkFC-jjekdd7lJvngsrrT2uCJgrXDGbUTGEcex5T_ffGrPbi8rH_t-\_YFcs",
"ip": "103.186.96.51",
"device": "Unknown Device",
"platform": "Unknown Platform",
"browser": "Unknown Browser"
}
}

##user role = masyarakat
{
"success": true,
"message": "Login berhasil.",
"data": {
"user": {
"name": "test",
"email": "test1@gmail.com",
"role": "masyarakat"
},
"token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIwMTljMDNlNi0zZGY2LTcyYTQtOWQ2Zi01MGQxZjFjYWQyNGMiLCJqdGkiOiI1ZTRhOTc3M2QyYTJhNGFmMGRlM2M5ZDkwNjJhYzgwMTNmMzczZjI1MmQxODMxNmFlOGJiZjc0YjY1ZTRlMTExYTkxNDJjNThmNDIzYzliOSIsImlhdCI6MTc2OTY1MDU5MC43MTMyNjYsIm5iZiI6MTc2OTY1MDU5MC43MTMyOSwiZXhwIjoxODAxMTg2NTkwLjcwNjkyNywic3ViIjoiMyIsInNjb3BlcyI6W119.sVwBvLpvwKq*s5g6UbIZBYc4cza4Tw2-dv8GkIazoij5c37M8GkfuATRW5red_G4UzL-r2ToqheUw4XOqZhnyDeZS7CNw5iARk4viO5iA873uUm1t9qgf8NY6jGaShMi25vOhZUSkSZBOk0PYDCmSRwDSRowsDRFMjwnwGxGeYZhgoSJxv3Pn165Pb8YOM6aeo6jTUy6NLrPAL99MckaRt8B6RKAZUoi9HZsecm4ksEGGgBs-19LKHU1j4pfaA2L7f8bRbq6PMq0rML6QLXSpgO7dWlpHglhJyAgoOaTpKw9HfpwbJGXRFuRwI3taTZ_itaJZUrhAb3MAPyw8lONtNQZnd84JpGyvPXOmblDqmhsdVHuXfe1_rMynDyqOsMpLkPznEvQWTSZV51pUCisjxwk6e1bEIHaDRXgxL7pvqh5A9aDvP4CX6TuSaVp2I-0GX32ObpKRuRFaU3GeVmTyef_z0eospBssmib0mzv-62_OKp3E3DVQEw93cNt1ddptoermLhY3KWndmvdnKGWzSariIgRVvTXZC8ZqRKqFEG9u-nzhF9ZSKXiPDyIrrbe9CxjPRPGTzIPWdk9qB125VTHUSq4IVvqzspr9gd-\_MenBNB8sWn6nN4G2MTnI4IYKjYaGCfSPqi85rpq4JYD*-81TNMCn0Rt9QZRGr_OefQ",
"ip": "103.186.96.51",
"device": "Unknown Device",
"platform": "Unknown Platform",
"browser": "Unknown Browser"
}
}

##respon json status 401 :
{
"success": false,
"message": "Email atau password salah."
}

#respon 422
{
"message": "Email wajib diisi (and 1 more error)",
"errors": {
"email": [
"Email wajib diisi"
],
"password": [
"Password wajib diisi"
]
}
}

##422 Format Email Tidak Valid
{
"message": "Format email tidak valid",
"errors": {
"email": [
"Format email tidak valid"
]
}
}
