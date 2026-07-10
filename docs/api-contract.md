# E-Commerce API Contract v1.0

ဒီစာရွက်စာတမ်းက E-Commerce Project ရဲ့ Backend (Laravel) နဲ့ Frontend (React) အကြား သဘောတူထားတဲ့ **တရားဝင် **API** စာချုပ် (Contract)** ဖြစ်ပါတယ်။ Frontend အနေနဲ့ ဒီ Response ပုံစံအတိုင်း Mock Data လုပ်ပြီး UI ကို သီးခြားဆောက်လို့ရပါပြီ။

---

## 1. အခြေခံအချက်အလက်များ (General Information)

| Key                | Value                                                                   |
| ------------------ | ----------------------------------------------------------------------- |
| **Base URL**       | `[http://localhost:8000/api/v1`](http://localhost:8000/api/v1`) (Local) |
| **Version**        | v1                                                                      |
| **Format**         | JSON                                                                    |
| **Charset**        | UTF-8                                                                   |
| **Authentication** | Bearer Token (Laravel Sanctum)                                          |

### လိုအပ်သော Headers များ (Default Headers)

```http
Accept: application/json
Content-Type: application/json
Authentication လိုအပ်သော Headers (Protected Routes)
http
Authorization: Bearer {access_token}
## Response Structure (ပုံသေပုံစံ)
အောင်မြင်သော Response (Success)
json
{
    *status*: *success*,
    *data*: { ... }
}
အမှားဖြစ်သော Response (Error)
json
{
    *status*: *error*,
    *message*: *Error description*,
    *errors*: {} // Validation errors အတွက် (optional)
}
### Status Codes
Code	အဓိပ္ပါယ်
**200**	OK (အောင်မြင်)
**201**	Created (အသစ်ဖန်တီးပြီး)
**400**	Bad Request (မှားယွင်းသော Request)
**401**	Unauthorized (Token မပါ သို့မဟုတ် မမှန်ကန်)
**403**	Forbidden (ခွင့်ပြုချက်မရှိ)
**404**	Not Found (မတွေ့ပါ)
**422**	Validation Error (Data မှားနေခြင်း)
**500**	Internal Server Error (Server ဘက်မှအမှား)
## Authentication (အများပြည်သူသုံး)
3.1 Register (အကောင့်သစ်ဖွင့်ခြင်း)
Endpoint: **POST** /register

Request Body:

json
{
    *name*: *John Doe*,
    *email*: *[john@example.com](mailto:john@example.com)*,
    *password*: *password123*,
    *password_confirmation*: *password123*
}
Response (**201** Created):

json
{
    *status*: *success*,
    *data*: {
    *user*: {
    *id*: 1,
    *name*: *John Doe*,
    *email*: *[john@example.com](mailto:john@example.com)*,
    *role*: *customer*
    },
    *token*: *1|abc123def456...*
    }
}
Error (**422**):

json
{
    *status*: *error*,
    *errors*: {
    *email*: [*The email has already been taken.*],
    *password*: [*The password confirmation does not match.*]
    }
}
3.2 Login (အကောင့်ဝင်ခြင်း)
Endpoint: **POST** /login

Request Body:

json
{
    *email*: *[john@example.com](mailto:john@example.com)*,
    *password*: *password123*
}
Response (**200** OK):

json
{
    *status*: *success*,
    *data*: {
    *user*: {
    *id*: 1,
    *name*: *John Doe*,
    *email*: *[john@example.com](mailto:john@example.com)*,
    *role*: *customer*
    },
    *token*: *1|def456ghi789...*
    }
}
Error (**401** Unauthorized):

json
{
    *status*: *error*,
    *message*: *The provided credentials are incorrect.*
}
3.3 Logout (အကောင့်ထွက်ခြင်း)
Endpoint: **POST** /logout
Authentication: Required

Headers:

http Authorization: Bearer {token} Response (**200** OK):

json
{
    *status*: *success*,
    *message*: *Logged out successfully*
}
3.4 Get Current User (လက်ရှိအသုံးပြုသူ)
Endpoint: **GET** /user
Authentication: Required

Response (**200** OK):

json
{
    *status*: *success*,
    *data*: {
    *id*: 1,
    *name*: *John Doe*,
    *email*: *[john@example.com](mailto:john@example.com)*,
    *role*: *customer*,
    *created_at*: ***2025**-06-17 10:00:00*
    }
}
## Products (အများပြည်သူသုံး)
4.1 ကုန်ပစ္စည်းစာရင်း (List Products)
Endpoint: **GET** /products

Query Parameters (Optional):

Parameter	Type	Description	Default
page	integer	စာမျက်နှာ	1
limit	integer	တစ်မျက်နှာလျှင် အရေအတွက်	10
category_id	integer	Category ID ဖြင့် စစ်ထုတ်	-
search	string	အမည်ဖြင့် ရှာဖွေ	-
sort_by	string	စီရမည့် Column (price, name, id)	-
sort_direction	string	asc သို့မဟုတ် desc	asc
Response (**200** OK):

json
{
    *status*: *success*,
    *data*: {
    *products*: [
    {
    *id*: 1,
    *name*: *Men's Cotton T-Shirt*,
    *slug*: *mens-cotton-t-shirt*,
    *description*: *High quality **100**% cotton t-shirt.*,
    *price*: ***25000**.00*,
    *stock_quantity*: 50,
    *category*: {
    *id*: 2,
    *name*: *Shirts*,
    *slug*: *shirts*
    },
    *image_urls*: [
    *[https://example.com/images/shirt-1.jpg*,](https://example.com/images/shirt-1.jpg*,)
    *[https://example.com/images/shirt-2.jpg*](https://example.com/images/shirt-2.jpg*)
    ],
    *created_at*: ***2025**-06-17 10:00:00*,
    *updated_at*: ***2025**-06-17 10:00:00*
    }
    ],
    *pagination*: {
    *current_page*: 1,
    *per_page*: 10,
    *total*: 48,
    *last_page*: 5
    }
    }
}
4.2 ကုန်ပစ္စည်းအသေးစိတ် (Single Product)
Endpoint: **GET** /products/{id}

Path Parameter:

Parameter	Type	Description
id	integer	Product ID
Response (**200** OK):

json
{
    *status*: *success*,
    *data*: {
    *id*: 1,
    *name*: *Men's Cotton T-Shirt*,
    *slug*: *mens-cotton-t-shirt*,
    *description*: *High quality **100**% cotton t-shirt.*,
    *price*: ***25000**.00*,
    *stock_quantity*: 50,
    *category*: {
    *id*: 2,
    *name*: *Shirts*,
    *slug*: *shirts*
    },
    *image_urls*: [
    *[https://example.com/images/shirt-1.jpg*,](https://example.com/images/shirt-1.jpg*,)
    *[https://example.com/images/shirt-2.jpg*](https://example.com/images/shirt-2.jpg*)
    ],
    *created_at*: ***2025**-06-17 10:00:00*,
    *updated_at*: ***2025**-06-17 10:00:00*
    }
}
Error (**404**):

json
{
    *status*: *error*,
    *message*: *Product not found*
}
4.3 ပစ္စည်းအမျိုးအစားများ (Categories)
Endpoint: **GET** /categories

Response (**200** OK):

json
{
    *status*: *success*,
    *data*: [
    {
    *id*: 1,
    *name*: *Men*,
    *slug*: *men*,
    *created_at*: ***2025**-06-17 10:00:00*,
    *updated_at*: ***2025**-06-17 10:00:00*,
    *children*: [
    {
    *id*: 2,
    *name*: *Shirts*,
    *slug*: *shirts*,
    *parent_id*: 1,
    *created_at*: ***2025**-06-17 10:00:00*,
    *updated_at*: ***2025**-06-17 10:00:00*,
    *children*: [
    {
    *id*: 3,
    *name*: *Long Sleeve*,
    *slug*: *long-sleeve*,
    *parent_id*: 2,
    *created_at*: ***2025**-06-17 10:00:00*,
    *updated_at*: ***2025**-06-17 10:00:00*,
    *children*: []
    },
    {
    *id*: 4,
    *name*: *Short Sleeve*,
    *slug*: *short-sleeve*,
    *parent_id*: 2,
    *created_at*: ***2025**-06-17 10:00:00*,
    *updated_at*: ***2025**-06-17 10:00:00*,
    *children*: []
    }
    ]
    },
    {
    *id*: 5,
    *name*: *Pants*,
    *slug*: *pants*,
    *parent_id*: 1,
    *created_at*: ***2025**-06-17 10:00:00*,
    *updated_at*: ***2025**-06-17 10:00:00*,
    *children*: []
    }
    ]
    },
    {
    *id*: 6,
    *name*: *Women*,
    *slug*: *women*,
    *created_at*: ***2025**-06-17 10:00:00*,
    *updated_at*: ***2025**-06-17 10:00:00*,
    *children*: []
    }
    ]
}
## Cart (Authentication Required)
5.1 ဈေးခြင်းကြည့်ရန် (Get Cart)
Endpoint: **GET** /cart
Authentication: Required

Response (**200** OK):

json
{
    *status*: *success*,
    *data*: {
    *cart_id*: 5,
    *items*: [
    {
    *id*: 10,
    *product_id*: 1,
    *name*: *Men's Cotton T-Shirt*,
    *price*: ***25000**.00*,
    *quantity*: 2,
    *subtotal*: ***50000**.00*
    },
    {
    *id*: 11,
    *product_id*: 3,
    *name*: *Long Sleeve Shirt*,
    *price*: ***35000**.00*,
    *quantity*: 1,
    *subtotal*: ***35000**.00*
    }
    ],
    *total*: ***85000**.00*
    }
}
5.2 ဈေးခြင်းထဲထည့်ရန် (Add to Cart)
Endpoint: **POST** /cart/items
Authentication: Required

Request Body:

json
{
    *product_id*: 1,
    *quantity*: 1
}
Response (**200** OK) (Cart အသစ်ပြန်ပေး):

json
{
    *status*: *success*,
    *data*: {
    *cart_id*: 5,
    *items*: [...],
    *total*: ***85000**.00*
    }
}
Error (**422**):

json
{
    *status*: *error*,
    *errors*: {
    *product_id*: [*The selected product id is invalid.*]
    }
}
5.3 ဈေးခြင်းထဲက ပစ္စည်းအရေအတွက်ပြင်ရန် (Update Cart Item)
Endpoint: **PUT** /cart/items/{cart_item_id}
Authentication: Required

Path Parameter:

Parameter	Type	Description
cart_item_id	integer	Cart Item ID
Request Body:

json { *quantity*: 3 } Response (**200** OK):

json
{
    *status*: *success*,
    *data*: { /* Complete Cart */ }
}
5.4 ဈေးခြင်းထဲက ပစ္စည်းဖယ်ရှားရန် (Remove Cart Item)
Endpoint: **DELETE** /cart/items/{cart_item_id}
Authentication: Required

Response (**200** OK):

json
{
    *status*: *success*,
    *message*: *Item removed from cart*
}
## Orders (Authentication Required)
6.1 မှာယူရန် (Place Order / Checkout)
Endpoint: **POST** /orders
Authentication: Required

Request Body:

json
{
    *shipping_address*: *Yangon, Hlaing Township, Room 42, Street 13*,
    *payment_method*: *cod*
}
မှတ်ချက်: payment_method က cod (Cash on Delivery) သို့မဟုတ် fake_payment ဖြစ်နိုင်သည်။

Response (**201** Created):

json
{
    *status*: *success*,
    *data*: {
    *order_id*: **101**,
    *total_amount*: ***85000**.00*,
    *status*: *pending*,
    *shipping_address*: *Yangon, Hlaing Township, Room 42, Street 13*,
    *payment_method*: *cod*,
    *created_at*: ***2025**-06-17 10:30:00*
    }
}
Error (**422** - Cart Empty):

json
{
    *status*: *error*,
    *message*: *Cart is empty*
}
6.2 မိမိမှာထားသော Order စာရင်း (My Orders)
Endpoint: **GET** /orders
Authentication: Required

Response (**200** OK):

json
{
    *status*: *success*,
    *data*: [
    {
    *id*: **101**,
    *total_amount*: ***85000**.00*,
    *status*: *pending*,
    *created_at*: ***2025**-06-17 10:30:00*
    },
    {
    *id*: **100**,
    *total_amount*: ***25000**.00*,
    *status*: *delivered*,
    *created_at*: ***2025**-06-15 15:00:00*
    }
    ]
}
6.3 Order အသေးစိတ် (Order Detail)
Endpoint: **GET** /orders/{id}
Authentication: Required

Path Parameter:

Parameter	Type	Description
id	integer	Order ID
Response (**200** OK):

json
{
    *status*: *success*,
    *data*: {
    *id*: **101**,
    *total_amount*: ***85000**.00*,
    *status*: *pending*,
    *shipping_address*: *Yangon, Hlaing Township, Room 42, Street 13*,
    *payment_method*: *cod*,
    *items*: [
    {
    *product_name*: *Men's Cotton T-Shirt*,
    *quantity*: 2,
    *price_at_time*: ***25000**.00*,
    *subtotal*: ***50000**.00*
    },
    {
    *product_name*: *Long Sleeve Shirt*,
    *quantity*: 1,
    *price_at_time*: ***35000**.00*,
    *subtotal*: ***35000**.00*
    }
    ],
    *created_at*: ***2025**-06-17 10:30:00*
    }
}
Error (**403**) (မိမိမဟုတ်သော Order ကိုကြည့်လျှင်):

json
{
    *status*: *error*,
    *message*: *Unauthorized*
}
## Admin (Role = admin အတွက်သာ)
7.1 ကုန်ပစ္စည်းအသစ်ထည့်ရန် (Create Product)
Endpoint: **POST** /admin/products
Authentication: Required + Admin Role

Request Body:

json
{
    *name*: *New Summer Shirt*,
    *description*: *Very cool and comfortable.*,
    *price*: **29000**,
    *stock_quantity*: **100**,
    *category_id*: 3,
    *image_urls*: [*[https://example.com/img1.jpg*,](https://example.com/img1.jpg*,) *[https://example.com/img2.jpg*]](https://example.com/img2.jpg*])
}
slug မထည့်ပါက name ကို အလိုအလျောက် slug ပြောင်းပေးမည်။

Response (**201** Created):

json
{
    *status*: *success*,
    *data*: {
    *id*: 10,
    *name*: *New Summer Shirt*,
    *slug*: *new-summer-shirt*,
    *description*: *Very cool and comfortable.*,
    *price*: ***29000**.00*,
    *stock_quantity*: **100**,
    *category*: {
    *id*: 3,
    *name*: *Long Sleeve*,
    *slug*: *long-sleeve*
    },
    *image_urls*: [*[https://example.com/img1.jpg*,](https://example.com/img1.jpg*,) *[https://example.com/img2.jpg*],](https://example.com/img2.jpg*],)
    *created_at*: ***2025**-06-17 11:00:00*,
    *updated_at*: ***2025**-06-17 11:00:00*
    }
}
7.2 ကုန်ပစ္စည်းပြင်ဆင်ရန် (Update Product)
Endpoint: **PUT** /admin/products/{id}
Authentication: Required + Admin Role

Request Body (ပြင်လိုသည့် အကွက်များကိုသာ ထည့်ပါ):

json
{
    *price*: **15000**,
    *stock_quantity*: **200**
}
Response (**200** OK):

json
{
    *status*: *success*,
    *data*: {
    *id*: 10,
    *name*: *New Summer Shirt*,
    *price*: ***15000**.00*,
    *stock_quantity*: **200**
    }
}
7.3 ကုန်ပစ္စည်းဖျက်ရန် (Delete Product)
Endpoint: **DELETE** /admin/products/{id}
Authentication: Required + Admin Role

Response (**200** OK):

json
{
    *status*: *success*,
    *message*: *Product deleted*
}
## Frontend Integration Guide (React)
8.1 **API** Client Setup (Axios)
javascript
import axios from 'axios';

const api = axios.create({
    baseURL: '[http://localhost:**8000**/api/v1',](http://localhost:**8000**/api/v1',)
    headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    },
});

// Interceptor for token
api.interceptors.request.use((config) => {
    const token = localStorage.getItem('token');
    if (token) {
    config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export default api;
8.2 Authentication Flow
javascript
// Register
const register = async (userData) => {
    const response = await api.post('/register', userData);
    const { token, user } = response.data.data;
    localStorage.setItem('token', token);
    return user;
};

// Login
const login = async (credentials) => {
    const response = await api.post('/login', credentials);
    const { token, user } = response.data.data;
    localStorage.setItem('token', token);
    return user;
};

// Logout
const logout = async () => {
    await api.post('/logout');
    localStorage.removeItem('token');
};

// Get User
const getUser = async () => {
    const response = await api.get('/user');
    return response.data.data;
};
8.3 Cart Operations
javascript
// Get Cart
const getCart = async () => {
    const response = await api.get('/cart');
    return response.data.data;
};

// Add to Cart
const addToCart = async (productId, quantity) => {
    const response = await api.post('/cart/items', { product_id: productId, quantity });
    return response.data.data; // Updated cart
};

// Update Cart Item
const updateCartItem = async (cartItemId, quantity) => {
    const response = await api.put(`/cart/items/${cartItemId}`, { quantity });
    return response.data.data; // Updated cart
};

// Remove Cart Item
const removeCartItem = async (cartItemId) => {
  await api.delete(`/cart/items/${cartItemId}`);
};
8.4 Order Operations
javascript
// Place Order
const placeOrder = async (orderData) => {
    const response = await api.post('/orders', orderData);
    return response.data.data;
};

// Get Orders
const getOrders = async () => {
    const response = await api.get('/orders');
    return response.data.data;
};

// Get Order Detail
const getOrderDetail = async (orderId) => {
    const response = await api.get(`/orders/${orderId}`);
    return response.data.data;
};
## Error Handling (Frontend)
javascript
try {
    const response = await api.post('/login', credentials);
    // Handle success
} catch (error) {
    if (error.response) {
    const { status, data } = error.response;

    if (status === **422**) {
    // Validation errors
    const errors = data.errors;
    // Show errors to user
    } else if (status === **401**) {
    // Unauthorized - Redirect to login
    localStorage.removeItem('token');
    } else if (status === **403**) {
    // Forbidden - Show permission error
    } else if (status === **404**) {
    // Not found
    } else {
    // Server error (**500**)
    console.error('Server error:', data.message);
    }
    }
}
## Changelog
Version	Date	Changes
v1.0.0	**2025**-06-17	Initial Release - **MVP**
End of Contract
```
