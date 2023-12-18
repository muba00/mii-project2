import React from 'react'
import { Button, Layout, version } from 'antd'

import { DoubleRightOutlined } from '@ant-design/icons'

const { Header, Content, Footer } = Layout

export default function HomePage() {

    return (
        <Layout style={{ minHeight: '100vh' }}>
            <Header>Select Operation:</Header>
            <Content style={{ padding: '20px' }}>
                <Button icon={<DoubleRightOutlined />} style={{ marginBottom: '10px', textAlign: 'left' }} type="default" block>Receive Items</Button>
                <Button icon={<DoubleRightOutlined />} style={{ marginBottom: '10px', textAlign: 'left' }} type="default" block>Move Items (Internal)</Button>
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
