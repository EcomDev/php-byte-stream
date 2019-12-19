# Zero Copy Bytes 

When you develop an async service accumulation of input data can get expensive memory-wise and as a result slow down your app. 

This library is meant to solve a problem by introducing abstraction around input strings as `Bytes`. `Bytes` can be added into `Buffer` so instead of concatenating strings, your original allocalted string will be used for your parser.  
