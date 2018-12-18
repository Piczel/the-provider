class Ajax
{
    static json(
        to,
        json = undefined
    ) {
        // Send json and receive json

        // Return a new promise
        return new Promise(function(resolve, reject) {
            let xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                    let responseJSON = this.responseText;
                    console.log(responseJSON);
                   // let response = JSON.parse(responseJSON);
                    
                    resolve(responseJSON);
                    
                } else if(this.readyState == 4 && this.status != 200) {
                    resolve(JSON.stringify({
                        "status" : false,
                        "message" : "Error sending request"
                    }));
                }
            };
            xhr.open("POST", to, true);

            if(json == undefined) {
                xhr.send();
            } else {
                xhr.setRequestHeader("Content-type", "application/json");
                xhr.send(JSON.stringify(json));
            }
        });
    }
}
