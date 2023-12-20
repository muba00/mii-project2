import React, { useEffect, useRef } from 'react'


async function streamVideo(videoEl) {
    const stream = await navigator.mediaDevices.getUserMedia({
        video: {
            facingMode: { ideal: 'environment' }
        },
        audio: false
    });

    videoEl.srcObject = stream;
    await videoEl.play();

    return stream;
}

function destroyVideo(stream) {
    const tracks = stream.getTracks();

    tracks.forEach(function (track) {
        track.stop();
    });
}

async function detectQRcode(videoEl, setScannedLocationQRCode, stream) {
    const barcodeDetector = new BarcodeDetector({
        formats: ['qr_code']
    });

    const interval = setInterval(async () => {
        const barcodes = await barcodeDetector.detect(videoEl);
        if (barcodes.length > 0) {
            clearInterval(interval);
            destroyVideo(stream);
            setScannedLocationQRCode(barcodes[0].rawValue);
        }
    }, 1000);

    return interval;
}

export default function LocationScanner({ setScannedLocationQRCode }) {
    const videoRef = useRef(null);

    useEffect(() => {
        let interval;
        let stream;
        streamVideo(videoRef.current).then((st) => {
            stream = st;
            interval = detectQRcode(videoRef.current, setScannedLocationQRCode, stream);
        });

        return () => {
            clearInterval(interval);
            destroyVideo(stream);
        }
    }, [])


    return (
        <div>
            <video className="video-stream" ref={videoRef} />
        </div>
    )
}
