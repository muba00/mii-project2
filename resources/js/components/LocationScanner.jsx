import React, { useEffect } from 'react'


async function streamVideo() {
    const stream = await navigator.mediaDevices.getUserMedia({
        video: {
            facingMode: { ideal: 'environment' }
        },
        audio: false
    });
    const videoEl = document.querySelector('#scanner');
    videoEl.srcObject = stream;
    await videoEl.play();

    return videoEl;
}

function destroyVideo(videoEl) {
    const stream = videoEl.srcObject;
    const tracks = stream.getTracks();

    tracks.forEach(function (track) {
        track.stop();
    });

    videoEl.srcObject = null;
}

async function detectQRcode(videoEl, setScannedLocationQRCode) {
    const barcodeDetector = new BarcodeDetector({
        formats: ['qr_code']
    });

    const interval = setInterval(async () => {
        const barcodes = await barcodeDetector.detect(videoEl);
        if (barcodes.length > 0) {
            clearInterval(interval);
            destroyVideo(videoEl);
            setScannedLocationQRCode(barcodes[0].rawValue);
        }
    }, 1000);

    return interval;
}

export default function LocationScanner({ setScannedLocationQRCode }) {
    useEffect(() => {
        let interval;
        streamVideo().then((videoEl) => {
            interval = detectQRcode(videoEl, setScannedLocationQRCode);
        });

        return () => {
            clearInterval(interval);
        }
    }, [])


    return (
        <div>
            <video id="scanner" />
        </div>
    )
}
