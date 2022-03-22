const chatForm = document.getElementById('chat-form');
const chatMessages = document.querySelector('.chat-messages');
const roomName = document.getElementById('room-name');
const userList = document.getElementById('users');

// get username and room from URL
const userDetail = { username, room } = Qs.parse(location.search, {
    ignoreQueryPrefix: true
});
function formatMessage(userName, text, time) {
    return {
        userName,
        text,
        time
    }
};

// output message to DOM
function outputMessage(message) {
    const div = document.createElement('div');
    div.classList.add('message');
    div.innerHTML = `<p style="color:orange" class="meta">${message.userName} <span>${message.time}</span></p>
    <p class="text">
        ${message.text}
    </p>`;
    document.querySelector('.chat-messages').appendChild(div);
}

// message submition
chatForm.addEventListener('submit', (e) => {
    e.preventDefault(); // prevents from submitting to a form
    
    // get message text value
    const text = e.target.elements.msg.value;
    // get time
    var today = new Date();
    var time = today.getFullYear() + "-" + today.getMonth() + "-" + today.getDate() + " " +
    today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds(); 
    // emitting a messsage to the server
    console.log(userDetail.username);
    
            
    var group_id = $('#group_id').val();    
    
    $.ajax({
        url: "./messagesToDB.php",
        method: "POST",
        data: {
            text: text,
            time: time,
            group_id: group_id			
        },
        cache: false,
        success: function(data) {
            console.log(data);
        },
        error: function(xhr, status, error) {
            console.error(xhr);
        }
    });

    const msg = formatMessage(userDetail.username, text, time);
    outputMessage(msg);

    // scroll down in message window
    chatMessages.scrollTop = chatMessages.scrollHeight; 

    // clear message input after user presses enter
    e.target.elements.msg.value = '';
    e.target.elements.msg.focus();     
});

// check if there are new posts every 2 seconds.
// if there are new posts, insert them at the bottom
var max = 0;
setInterval (updateMessages, 5000); // 1000 = 1 second.
function updateMessages() {
    var group_id = $('#group_id').val();     
    
    var numMessages = document.getElementsByClassName("message");    
    console.log("number of posts: " + numMessages.length);    
    
    // find the most recent post_id
    // will use this to check if there are newer posts
    for (var i = 0; i < numMessages.length; i++) {
        // id value will be a string so need to use function parseInt to convert to int value
        var m_id = parseInt(numMessages[i].id);       
        if (max < m_id) {
            max = m_id;
        }
    }        
    
    console.log("most recent message id is " + max);    

    $.ajax({
        url: "./updateMessages.php",
        method: "POST",
        data: {
            group_id: group_id,      
            max: max,   			
        },
        cache: false,
        success: function(data) {            
            var responseObj = JSON.parse(data);
            for (var i = 0; i < responseObj.length; i++) {
                const div = document.createElement('div');
                div.id=responseObj[i].idMessages;
                div.classList.add('message');
                div.innerHTML = `<p class="meta">${responseObj[i].profilename} <span>${responseObj[i].Time}</span></p>
                <p class="text">
                    ${responseObj[i].Text}
                </p>`;
                document.querySelector('.chat-messages').appendChild(div);
            }
            console.log("Max: "+max);
        },
        error: function(xhr, status, error) {
            console.error(xhr);
        }
    });    
}