function one(value){
    console.log(value);

}; 
function two(callback){
    const value = 'callback test';
    callback(value); 
};
two(one);