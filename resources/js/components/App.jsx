import React from 'react'
import './../../css/app.css'
import HomePage from './HomePage'
import ReceiveItemsPage from './ReceiveItemsPage'
import { BrowserRouter, Routes, Route } from 'react-router-dom'

export default function App() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/" element={<HomePage />} />
                <Route path="/receive" element={<ReceiveItemsPage />} />
            </Routes>
        </BrowserRouter>
    )
}
