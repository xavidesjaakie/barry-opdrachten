
        function showTable() {
 
            const number = document.getElementById("inputNumber").value;

 
            if (!number || isNaN(number)) {
                document.getElementById("result").innerHTML = "Voer een geldig getal in!";
                return;
            }


            const resultDiv = document.getElementById("result");
            resultDiv.innerHTML = ""; 

    
            for (let i = 1; i <= 10; i++) {
                const result = `${i} x ${number} = ${i * number}`;
                const paragraph = document.createElement("p");
                paragraph.textContent = result;
                resultDiv.appendChild(paragraph);
            }
        }
