
function confirmDelete(id){
    const url = '/admin/category/' + id + '/delete';
    const modal = '#deleteModal' + id;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');//chuỗi mã

    //capcha
    var recaptchaResponse = grecaptcha.getResponse(recaptchaWidgets[id]);

    if (!recaptchaResponse) {
        alert('Please complete the CAPTCHA.');
        return;
    }
    fetch(url, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json'
        },
        //capcha
        body: JSON.stringify({
            recaptcha_response: recaptchaResponse
        })
    })
    .then(response => {
        // Kiểm tra phản hồi có OK (status 200-299) hay không
        if (!response.ok) {
            throw new Error('Network response was not ok.');
        }
        // Trả về JSON nếu thành công
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Xóa dòng category khỏi bảng
            document.getElementById('category_' + id).remove();
            // Đóng modal
            $(modal).modal('hide');
            // Thông báo thành công
            alert(data.message);
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        alert('Something went wrong.');
        console.error('Error:', error);
    });
}



// Đối tượng lưu trữ các widget CAPTCHA đã render
let recaptchaWidgets = {};

// Khi modal được hiển thị
$('.modal').on('shown.bs.modal', function (e) {
    var modalId = $(this).attr('id'); // Lấy ID của modal đang mở
    var categoryId = modalId.split('deleteModal')[1]; // Lấy category ID từ modal ID

    // Kiểm tra nếu reCAPTCHA đã được render
    if (!recaptchaWidgets[categoryId]) {
        // Render reCAPTCHA lần đầu tiên
        recaptchaWidgets[categoryId] = grecaptcha.render('recaptcha_' + categoryId, {
            sitekey: '6Ld8vGMqAAAAAA-JUbpmbSCPRYdhLNrS-NwQnV7A',
            callback: function () {
                console.log('recaptcha callback');
            }
        });
    }
});
