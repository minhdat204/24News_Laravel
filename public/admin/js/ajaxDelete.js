document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    document.querySelectorAll('.confirmDelete').forEach(function(button) {
        button.addEventListener('click', function() {
            // Tìm modal cha của nút được nhấn
            var modal = button.closest('.modal');
            // Lấy category ID từ modal hiện tại
            var categoryId = modal.querySelector('.categoryId').value;
            var url = '/admin/category/' + categoryId + '/delete';


            //capcha
            var recaptchaResponse = grecaptcha.getResponse();

            if (!recaptchaResponse) {
                alert('Please complete the CAPTCHA.');
                return;
            }


            if (confirm('Are you sure you want to delete this category?')) {
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
                        document.getElementById('category_' + categoryId).remove();
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
        });
    });
});
