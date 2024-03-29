import React from 'react'
import { Button, Layout, version } from 'antd'

import { LeftOutlined } from '@ant-design/icons'
import ItemScanner from './ItemScanner'
import LocationScanner from './LocationScanner'
import { useNavigate } from "react-router-dom"
import { message } from 'antd'

const { Header, Content, Footer } = Layout

export default function ReceiveItemsPage() {
    const navigate = useNavigate();
    const [scannedBarcode, setScannedBarcode] = React.useState('');
    const [scannedLocationQRCode, setScannedLocationQRCode] = React.useState('');
    const [scannedItem, setScannedItem] = React.useState();
    const [scannedLocation, setScannedLocation] = React.useState('');
    const [loading, setLoading] = React.useState(false);

    const [messageApi, contextHolder] = message.useMessage();

    const success = (m) => {
        messageApi.open({
            type: 'success',
            content: m,
        });
    };

    const error = (m) => {
        messageApi.open({
            type: 'error',
            content: m,
        });
    };

    React.useEffect(() => {
        if (scannedBarcode) {
            setLoading(true);
            fetch(`/api/items/${scannedBarcode}`,
                {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data?.id) {
                        setScannedItem(data);
                    } else {
                        error('Item not found');
                        setScannedBarcode('');
                    }
                })
                .finally(() => {
                    setLoading(false);
                });
        }
    }, [scannedBarcode]);


    React.useEffect(() => {
        if (scannedLocationQRCode) {
            console.log(scannedLocationQRCode);
            setLoading(true);
            fetch(`/api/warehouselocation-by-code/${scannedLocationQRCode}`,
                {
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data?.id) {
                        setScannedLocation(data);
                    } else {
                        error('Warehouse Location not found');
                        setScannedLocationQRCode('');
                    }
                })
                .finally(() => {
                    setLoading(false);
                });
        }
    }, [scannedLocationQRCode]);


    React.useEffect(() => {
        if (scannedItem && scannedLocation) {
            setLoading(true);
            fetch(`/api/receive-item`,
                {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }, body: JSON.stringify({
                        item_id: scannedItem.id,
                        warehouse_location_id: scannedLocation.id
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data?.id) {
                        success('Item received!');
                        setScannedBarcode('');
                        setScannedLocationQRCode('');
                        setScannedItem(null);
                        setScannedLocation(null);
                    } else {
                        error('Error receiving item');
                    }
                })
                .finally(() => {
                    setLoading(false);
                });
        }
    }, [scannedItem, scannedLocation]);

    return (
        <>
            {contextHolder}
            <Layout style={{ minHeight: '100vh' }}>
                {loading &&
                    <div style={{ position: 'absolute', top: '0', left: '0', width: '100%', height: '100%', backgroundColor: 'rgba(0,0,0,0.5)', zIndex: '1000' }}>
                        <div style={{ position: 'absolute', top: '50%', left: '50%', transform: 'translate(-50%, -50%)' }}>
                            <h1 style={{ color: 'white' }}>Loading...</h1>
                        </div>
                    </div>
                }
                <Header>
                    <Button
                        icon={<LeftOutlined />}
                        type="default"
                        onClick={() => navigate('/')}
                    />
                    <span style={{ marginLeft: '20px' }}>Receiving Items</span>
                </Header>
                <Content style={{ padding: '10px 20px' }}>
                    {!scannedItem ?
                        <>
                            <h2 style={{ textAlign: 'center' }}>Scan Item</h2>
                            <ItemScanner {...{ scannedBarcode, setScannedBarcode }} />
                        </>
                        :
                        <>
                            <h2>Scanned Item:</h2>
                            <div className="scanned-item">
                                <div>
                                    <img src={(scannedItem?.image_url) ? scannedItem?.image_url : '/imgs/box.svg'} alt={scannedItem?.name} />
                                </div>
                                <div className="info">
                                    <div className="title">{scannedItem?.name}</div>
                                    <div>GTIN: {scannedItem?.gtin}</div>
                                    <div>Weight: {scannedItem?.weight}</div>
                                </div>
                            </div>
                            <h2 style={{ textAlign: 'center' }}>Scan Location</h2>
                            <LocationScanner {...{ scannedLocationQRCode, setScannedLocationQRCode }} />
                        </>
                    }
                </Content>
                <Footer>
                    This is a demo for MII Project 2 for University of Applied Sciences Emden-Leer
                    by Mubariz Hajimuradov
                    <br />
                    <br />
                    React version: {React.version}<br />
                    Ant Design version: {version}<br />
                </Footer>
            </Layout>
        </>
    )
}
