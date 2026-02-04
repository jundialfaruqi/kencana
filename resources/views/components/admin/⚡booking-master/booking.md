1. Endpoint API = /v1/master/bookings
2. Type = POST
3. Auth Session = YES
4. Postman params = YES
5. Query Params = status
6. Params url example = /v1/master/bookings?status=dibatalkan
7. Key : status
   Value : ENUM (dibatalkan, dipesan, selesai)

8. Params search = user.name, kode_booking (contoh /v1/master/bookings?search=BK-20260201-MIYU)
9. from dan to = date format (2026-03-17) (contoh /v1/master/bookings?from=2026-03-17&to=2026-03-19)
