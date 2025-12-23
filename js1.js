function pickPropArray(arr, prop) {
    const result = [];
    
    for (let i = 0; i < arr.length; i++) {
        const obj = arr[i];
        
        if (obj[prop] !== undefined) {
            result.push(obj[prop]);
        }
    }
    
    return result;
}

const students = [
   { name: 'Павел', age: 20 },
   { name: 'Иван', age: 20 },
   { name: 'Эдем', age: 20 },
   { name: 'Денис', age: 20 },
   { name: 'Виктория', age: 20 },
   { age: 40 },
]

const result = pickPropArray(students, 'name')

console.log(result) 