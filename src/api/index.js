import path from 'path'
import express from 'express'
import jsonServer from 'json-server'
// import db from './data'

const api = express()

// api.use('/api', jsonServer.router(db()))
api.use('/api', jsonServer.router(path.join(__dirname, '..', 'api', 'data.json')))

export default api
