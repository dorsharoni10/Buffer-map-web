

$('document').ready(function()
{
    $('#contact').click(function()
    {
        $.post(escapeHtml("Contact.php"),
        {
            name: $('#name').val(),
            email: $('#email').val(),
            message: $('#message').val()

        },

        function(data)
        {
            console.log(data);
        });
    });

    $('#login').click(function()
    {
        $.post(escapeHtml("Login.php"),
        {
            username: $('#username').val(),
            password: $('#password').val()

        },

        function(data)
        {
            console.log(data);
        });
    });

    $('#signup').click(function()
    {
        $.post(escapeHtml("signup.php"),
        {
            username1: $('#username1').val(),
            psw1: $('#psw1').val(),
			email1: $('#email1').val()

		},

        function(data)
        {
            console.log(data);
        });
    });
});


function escapeHtml(unsafe)
{
    unsafe.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");

    return unsafe
};
