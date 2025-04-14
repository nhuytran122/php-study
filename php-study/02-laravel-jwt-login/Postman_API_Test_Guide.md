
# HƯỚNG DẪN HOÀN CHỈNH TEST API AUTHENTICATION BẰNG POSTMAN CHO BACKEND INTERN

## 1. TẠO FOLDER `auth` TRONG POSTMAN

- Tạo folder `auth`
- Thêm các request liên quan:
  - `POST /register`
  - `POST /login`
  - `POST /logout`
  - `POST /refresh`

## 2. CẤU HÌNH `AUTHORIZATION` CHO FOLDER `auth`

> Mục tiêu: Dùng chung Bearer Token cho tất cả các request trong folder.

- Chọn folder `auth` → Tab **Authorization**
  - **Type:** `Bearer Token`
  - **Token:** `{{auth_token}}` (dùng biến môi trường)

## 3. TẠO MÔI TRƯỜNG (ENVIRONMENT)

- Chọn icon bánh răng ⚙ góc trên phải → `Manage Environments`
- Thêm environment mới (vd: `Laravel API`)
- Thêm biến:
  - `auth_token` → Để chứa JWT token
- **Chọn đúng environment khi gửi request**

## 4. CẤU HÌNH HEADER CHO CÁC REQUEST

> ✳️ Cần set Header `Accept: application/json` để Laravel hiểu rằng client (Postman) mong muốn response ở định dạng JSON.

### Vì sao cần `Accept: application/json`?

- Laravel có thể trả về HTML (trang lỗi) nếu không biết bạn đang gọi từ API.
- Nếu không có `Accept: application/json`, khi lỗi (ví dụ 401), Laravel có thể trả về HTML → Postman không parse được → lỗi `JSONError`.

**Trong tab `Headers` của mỗi request:**

| Key           | Value                 |
|----------------|------------------------|
| Accept         | application/json      |
| Content-Type   | application/json (tùy API POST có thể cần)|

## 5. THÊM TEST SCRIPT CHO REQUEST `/login`

> Tự động lưu JWT token vào biến `auth_token`

Trong tab `Tests` của request `/login`, thêm đoạn sau:

```javascript
pm.test("Save auth token", function () {
    var jsonData = pm.response.json();
    console.log(jsonData); // In ra để debug nếu cần
    pm.environment.set("auth_token", jsonData.authorization.token);
});
```

## 6. CẤU HÌNH CÁC REQUEST KHÁC (logout, refresh)

- Trong tab `Authorization` của từng request:
  - **Chọn:** `Inherit auth from parent`

Điều này giúp các request này tự dùng `Bearer Token` từ folder `auth` mà không cần gán lại.

## 7. CHẠY TEST

1. Chọn đúng Environment (`Laravel API`)
2. Gửi request `POST /register` hoặc `POST /login`
   - Xem tab `Console` (Ctrl + `) → check token đã được log chưa.
   - Biến `auth_token` có được set trong môi trường không.
3. Gửi request `POST /logout` hoặc `POST /refresh`
   - Nếu token đúng → sẽ thành công
   - Nếu token hết hạn → sẽ nhận lỗi từ API (ví dụ `401 Unauthorized`)

## 8. LỖI PHỔ BIẾN VÀ CÁCH XỬ LÝ

| Tình huống                        | Nguyên nhân                                         | Giải pháp                                        |
|----------------------------------|-----------------------------------------------------|--------------------------------------------------|
| `JSONError: No data, empty input` | Laravel trả về HTML do thiếu `Accept: application/json` | Thêm header `Accept: application/json`         |
| Token không được set             | Chưa chọn đúng environment hoặc chưa có test script | Chọn đúng environment và thêm script ở bước 5   |
| Các request sau không dùng được token | Chưa set `Inherit from parent`                    | Kiểm tra lại phần `Authorization` trong từng request |
