<?php



if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}


if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'th'; 
}

$lang_code = $_SESSION['lang'];


$lang_map = [
    'th' => [
        
        'home' => 'หน้าแรก',
        'setting' => 'ตั้งค่า',
        'login' => 'เข้าสู่ระบบ',
        'logout' => 'ออกจากระบบ',
        'username' => 'ชื่อผู้ใช้',
        'password' => 'รหัสผ่าน',
        'remember' => 'จำฉันไว้',
        'no_account' => 'ยังไม่มีบัญชี?',
        'register' => 'ลงทะเบียนที่นี่',
        'appearance' => 'รูปลักษณ์',
        'dark_mode' => 'โหมดสว่าง',
        'language' => 'ภาษา',
        'select_lang' => 'เลือกภาษา',
        'welcome' => 'ยินดีต้อนรับ',
        'manage_account' => 'จัดการบัญชี',
        'system_setting' => 'การตั้งค่าระบบ',

        
        'page_title_index' => 'ห้องสมุดของฉัน',
        'book_list' => 'รายการหนังสือ',
        'add_book' => 'เพิ่มหนังสือใหม่',
        'all' => 'ทั้งหมด',
        'novel' => 'นิยาย',
        'comic' => 'การ์ตูน',
        'search_placeholder' => 'ค้นหาชื่อหนังสือ...',
        'search_btn' => 'ค้นหา',
        'th_id' => 'ID',
        'th_title' => 'ชื่อหนังสือ',
        'th_category' => 'หมวดหมู่',
        'th_duration' => 'ระยะเวลา (วัน)',
        'th_status' => 'สถานะ / กำหนดส่ง',
        'th_manage' => 'จัดการ',
        'status_available' => 'ว่าง',
        'status_overdue' => 'เกินกำหนด',
        'return_due' => 'ส่งคืน:',
        'status_borrowed' => 'ถูกยืม',
        'btn_borrow' => 'ยืม',
        'btn_view' => 'ดูรายละเอียด',
        'btn_edit' => 'แก้ไข',
        'btn_delete' => 'ลบ',
        'confirm_delete' => 'คุณต้องการลบหนังสือเล่มนี้ใช่หรือไม่?',
        'btn_return' => 'คืน',
        'confirm_return' => 'ต้องการคืนหนังสือเล่มนี้ใช่หรือไม่?',
        'status_unavailable' => 'ไม่ว่าง',
        'no_data' => 'ไม่พบข้อมูลหนังสือในระบบ',

        
        'book_details_page_title' => 'รายละเอียดหนังสือ',
        'borrow_duration_label' => 'ระยะเวลายืม:',
        'days' => 'วัน',
        'status_label' => 'สถานะ:',
        'delivery_address' => 'ที่อยู่จัดส่ง (สำหรับ Admin)',
        'address_label' => 'ที่อยู่:',
        'delivery_point' => 'จุดส่งหนังสือ',
        'no_map' => 'ไม่มีข้อมูลพิกัดแผนที่',
        'btn_borrow_full' => 'ยืมหนังสือ',
        'btn_login_borrow' => 'เข้าสู่ระบบเพื่อยืม',
        'btn_return_full' => 'คืนหนังสือ',
        'btn_back' => 'กลับหน้าหลัก',
        'no_desc' => 'ไม่มีรายละเอียดเพิ่มเติม',
        'details_header' => 'รายละเอียด',

        
        'add_book_title' => 'เพิ่มหนังสือใหม่',
        'form_title' => 'ชื่อหนังสือ',
        'form_category' => 'หมวดหมู่',
        'form_select_cat' => '-- เลือกหมวดหมู่ --',
        'form_cover' => 'รูปปกหนังสือ (เฉพาะไฟล์รูปภาพ)',
        'form_desc' => 'รายละเอียดหนังสือ',
        'form_duration' => 'จำนวนวันที่ยืมได้ (วัน)',
        'btn_save' => 'บันทึกข้อมูล',
        'btn_cancel' => 'ยกเลิก',

        
        'unauthorized_add' => 'ไม่มีสิทธิ์เพิ่มหนังสือ'
    ],
    'en' => [
        
        'home' => 'Home',
        'setting' => 'Settings',
        'login' => 'Login',
        'logout' => 'Logout',
        'username' => 'Username',
        'password' => 'Password',
        'remember' => 'Remember Me',
        'no_account' => 'No account?',
        'register' => 'Register here',
        'appearance' => 'Appearance',
        'dark_mode' => 'Light Mode',
        'language' => 'Language',
        'select_lang' => 'Select Language',
        'welcome' => 'Welcome',
        'manage_account' => 'Manage Account',
        'system_setting' => 'System Settings',

        
        'page_title_index' => 'My Library',
        'book_list' => 'Book List',
        'add_book' => 'Add New Book',
        'all' => 'All',
        'novel' => 'Novel',
        'comic' => 'Comic',
        'search_placeholder' => 'Search book title...',
        'search_btn' => 'Search',
        'th_id' => 'ID',
        'th_title' => 'Title',
        'th_category' => 'Category',
        'th_duration' => 'Duration (days)',
        'th_status' => 'Status / Due Date',
        'th_manage' => 'Manage',
        'status_available' => 'Available',
        'status_overdue' => 'Overdue',
        'return_due' => 'Due:',
        'status_borrowed' => 'Borrowed',
        'btn_borrow' => 'Borrow',
        'btn_view' => 'Details',
        'btn_edit' => 'Edit',
        'btn_delete' => 'Delete',
        'confirm_delete' => 'Are you sure you want to delete this book?',
        'btn_return' => 'Return',
        'confirm_return' => 'Do you want to return this book?',
        'status_unavailable' => 'Unavailable',
        'no_data' => 'No book data found',

        
        'book_details_page_title' => 'Book Details',
        'borrow_duration_label' => 'Borrow Duration:',
        'days' => 'days',
        'status_label' => 'Status:',
        'delivery_address' => 'Delivery Address (Admin)',
        'address_label' => 'Address:',
        'delivery_point' => 'Delivery Point',
        'no_map' => 'No map coordinates',
        'btn_borrow_full' => 'Borrow Book',
        'btn_login_borrow' => 'Login to Borrow',
        'btn_return_full' => 'Return Book',
        'btn_back' => 'Back to Home',
        'no_desc' => 'No additional details',
        'details_header' => 'Details',

        
        'add_book_title' => 'Add New Book',
        'form_title' => 'Book Title',
        'form_category' => 'Category',
        'form_select_cat' => '-- Select Category --',
        'form_cover' => 'Cover Image',
        'form_desc' => 'Description',
        'form_duration' => 'Borrow Duration (days)',
        'btn_save' => 'Save Data',
        'btn_cancel' => 'Cancel',

        
        'unauthorized_add' => 'Unauthorized Access'
    ]
];


function __($key)
{
    global $lang_map, $lang_code;
    return isset($lang_map[$lang_code][$key]) ? $lang_map[$lang_code][$key] : $key;
}
?>