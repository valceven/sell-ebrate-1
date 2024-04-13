"use client";

import React, { useEffect, useState } from "react";
import axios from "axios";
import { serverDomain } from "@/util/server";
import { useRouter } from "next/router";
import { useUserStore } from "@/store/user";

function useGetProfile(userId: string | null) {
  const [profile, setProfile] = useState(null);

  useEffect(() => {
    const fetchProfile = async () => {
      const { data } = await axios.get(serverDomain + "profile.php", {
        auth: {},
      } as any);
      // TODO: toast here
      setProfile(data.data.profile);
    };
    fetchProfile();
  }, [userId]);

  return profile;
}

export default function Profile() {
  const { token } = useUserStore();

  // TODO: get other users profile
  // const { id } = router.query;

  const profile = useGetProfile(token);

  return <div>Data: {profile}</div>;
}
