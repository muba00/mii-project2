import React from 'react'
import { Button, Layout, version } from 'antd'
import { DoubleRightOutlined } from '@ant-design/icons'
import { useNavigate } from "react-router-dom"


const { Header, Content, Footer } = Layout

export default function HomePage() {
    const navigate = useNavigate();

    return (
        <Layout style={{ minHeight: '100vh' }}>
            <Header>Select Operation:</Header>

            <Content style={{ padding: '20px' }}>
                <Button
                    icon={<DoubleRightOutlined />}
                    style={{ marginBottom: '10px', textAlign: 'left' }}
                    type="default"
                    block
                    onClick={() => navigate('/receive')}
                >
                    Receive Items
                </Button>
                <Button
                    icon={<DoubleRightOutlined />}
                    style={{ marginBottom: '10px', textAlign: 'left' }}
                    type="default"
                    block
                >
                    Move Items (Internal)
                </Button>
                <Button
                    icon={<DoubleRightOutlined />}
                    style={{ marginBottom: '10px', textAlign: 'left' }}
                    type="default"
                    block
                    onClick={() => window.location.href = '/admin'}
                >
                    Admin Panel
                </Button>
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
    )
}
