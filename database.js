
const mysql = require('mysql');

//We create a connection pool with max 10 connections
//instead of create - query - end each connection
//pool is a 'shortcut'
pool  = mysql.createPool({
    port: 3306,
    host: "localhost",
    user: "ktouf",
    password: "kt324007",
    database: "academicAPI",
    connectionLimit: 10
});


// We return a promise that will be handled from the middleware
module.exports.callDB = (apm)=>{
        return new Promise((resolve,reject) =>{
            pool.query('SELECT * FROM students WHERE apm = ?', [apm], (error, result)=>{
                if(!error){
                     resolve(result); //if the query succeeds then we send back results
                }else{
                    reject(error);  //if the query fails we send back an error
                 }
        });
    });
};
