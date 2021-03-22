const express = require('express');
const app = express();
const {callDB} = require('./database');
const db_error = new Error('Database Connection Error');
const match_error = new Error('No entries were found matching this id');


//Handling CORS errors from the browser
//Because this is a RESTful API and it is supposed to 
//serve data to clients from different servers
//which can cause errors to browser

app.use((req, res, next)=>{
    res.header("Access-Control-Allow-Origin","*"); //Add this header to every result we send back
    res.header(
        "Access-Control-Allow-Headers",
        "Origin,X-Requested-With,Content-Type, Accept, Authorization"
    );
    if (req.method === 'OPTIONS'){
        //browser sends this request first thing to find out what he can do
        res.header('Access-Control-Allow-Methods','PUT,POST, PATCH, DELETE, GET');
        return res.status.json({}); //This API only serves GET method
    }
    next(); //After adding headers to every response hand the request to the next middleware
});



app.get('/academicIdRegistered/:acadID',(req, res, next)=>{
    callDB(req.params.acadID).then((results)=>{ //Call the callDB function. If it's successful we get back results from resolve() and handle them with .then
            if(!results.length){ //If no match with this apm was found in database
                next(match_error);
            }else{
                res.status(200).json({ //Return results
                registered: results[0].registered ? true : false,
                academicIdData: {
                    acid: results[0].academicID,
                    modifiedDate: null
                }
                });
            }
        }).catch((error)=>{next(db_error)}); //Handle the error we got from reject() with .catch
    
});

app.get('/gymStatus/:acadID',(req , res, next)=>{
    callDB(req.params.acadID).then((results)=>{
        if(!results.length){
            next(match_error);
        }else{
            if(results[0].gymStatus == 'not_reg'){
                gymStatusMessage = 'No registration data available'
            }else if(results[0].gymStatus == 'reg'){
                gymStatusMessage = 'Registered';
            }else{
                gymStatusMessage = 'Registration has expired';
            }
            res.status(200).json({
                gymReg: gymStatusMessage
            });
        }
    }).catch((error)=>{next(db_error)});

    
});

app.get('/diningStatus/:acadID',(req, res, next)=>{
    callDB(req.params.acadID).then((results)=>{
        if(!results.length){
            next(match_error);
        }else{
            res.status(200).json({
                reg: results[0].diningStatus ? true : false
            });
        }
    }).catch((error)=>{next(db_error)});
});

//This is the error handler that handles api related errors
//like wrong url or anything that passed the last three middlewares
app.use((req, res, next)=>{ 
    const err = new Error('Not Found!');
    err.status= 404;
    next(err);
});
//This is the handler that handles other kinds of errors like the
//DB errors or whatever
app.use((err, req, res, next)=>{
    res.status(err.status || 500);
    res.json({
        error: {
            message: err.message
        }
    })
});
module.exports = app;